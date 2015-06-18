<?php

namespace BlockCypher\Api;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Random\Rfc6979;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Signature\SignatureInterface;
use BitWasp\Buffertools\Buffer;
use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Crypto\PrivateKey;
use BlockCypher\Crypto\PrivateKeyList;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class TXSkeleton
 *
 * A TXSkeleton is a convenience/wrapper Object that’s used primarily when Creating Transactions through the New and Send endpoints.
 *
 * @package BlockCypher\Api
 *
 * @property \BlockCypher\Api\TX tx
 * @property string[] tosign
 * @property string[] signatures
 * @property string[] pubkeys
 */
class TXSkeleton extends BlockCypherResourceModel
{
    /**
     * Send the transaction to the network.
     *
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function send($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/send",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $this->fromJson($json);
        return $this;
    }

    /**
     * @param string[]|string $privateKeys
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @throws \Exception
     */
    public function sign($privateKeys, $apiContext = null)
    {
        $addresses = $this->getInputsAddresses();
        $tosign = $this->getTosign();

        // DEBUG
        //echo "txInputs: <br/>";
        //var_dump($txInputs);
        //echo "addresses: <br/>";
        //var_dump($addresses);
        //echo "tosign: <br/>";
        //var_dump($tosign);
        //die();

        $coinSymbol = $this->getCoinSymbol($apiContext);

        // DEBUG
        //echo "coinSymbol: $coinSymbol<br/>";
        //die();

        $network = $this->getNetwork($coinSymbol);
        $ecAdapter = Bitcoin::getEcAdapter();

        // Create PrivateKey objects from plain hex private keys
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($privateKeys, $ecAdapter, $network);

        // DEBUG
        //echo "privateKeyList: <br/>";
        //var_dump($privateKeyList);

        // Generate signatures
        $signatures = $this->generateSignatures($addresses, $tosign, $privateKeyList, $ecAdapter);
        $this->setSignatures($signatures);

        // DEBUG
        //echo "signatures: <br/>";
        //var_dump($signatures);

        // Generate pubkeys
        $pubkeys = $this->generatePubkeys($addresses, $privateKeyList);
        $this->setPubkeys($pubkeys);

        // DEBUG
        //echo "pubkeys: <br/>";
        //var_dump($pubkeys);
    }

    /**
     * Return an array of all inputs addresses in the same order they are in the json tx skeleton
     * @return string[]
     */
    private function getInputsAddresses()
    {
        $addresses = array();
        foreach ($this->getTx()->getInputs() as $txInput) {
            $addresses = array_merge($addresses, $txInput->getAddresses());
        }
        return $addresses;
    }

    /**
     * A temporary TX, usually returned fully filled but missing input scripts.
     *
     * @return \BlockCypher\Api\TX
     */
    public function getTx()
    {
        return $this->tx;
    }

    /**
     * Array of hex-encoded data for you to sign, one for each input.
     *
     * @return \string[]
     */
    public function getTosign()
    {
        return $this->tosign;
    }

    /**
     * @param $coinSymbol
     * @return \BitWasp\Bitcoin\Network\Network
     * @throws \Exception
     */
    private function getNetwork($coinSymbol)
    {
        switch ($coinSymbol) {
            case 'btc':
                $network = NetworkFactory::bitcoin();
                break;
            case 'btc-testnet':
                $network = NetworkFactory::bitcoinTestnet();
                break;
            // TODO: add all supported blockchains http://dev.blockcypher.com/?shell#restful-resources
            default:
                throw new \Exception("Unsupported coin symbol: $coinSymbol");
        }
        return $network;
    }

    /**
     * @param string[] $addresses
     * @param string[] $tosign
     * @param PrivateKeyList $privateKeyList
     * @param EcAdapterInterface $ecAdapter
     * @return \string[]
     * @throws \Exception
     */
    private function generateSignatures($addresses, $tosign, $privateKeyList, $ecAdapter)
    {
        $index = 0;
        $signatures = array();

        foreach ($addresses as $address) {

            $hexDataToSign = $tosign[$index++];

            if (!$privateKeyList->keyExists($address)) {
                throw new \Exception("Missing private key from address $address");
            }

            $privateKey = $privateKeyList->getKey($address);

            $sig = $this->signHexDataDeterministically($hexDataToSign, $privateKey, $ecAdapter);

            $signatures[] = $sig->getHex();

            // DEBUG
            //echo "sig: <br/>";
            //var_dump($sig->getHex());
        }

        return $signatures;
    }

    /**
     * Sign hex data deterministically using deterministic k.
     *
     * @param string $hexDataToSign
     * @param PrivateKey $privateKey
     * @param EcAdapterInterface $ecAdapter
     * @return SignatureInterface
     */
    private function signHexDataDeterministically($hexDataToSign, $privateKey, $ecAdapter)
    {
        // Convert hex data to buffer
        $data = Buffer::hex($hexDataToSign);

        // Deterministic digital signature generation
        $k = new Rfc6979($ecAdapter, $privateKey, $data, 'sha256');

        $sig = $ecAdapter->sign($data, $privateKey, $k);

        // DEBUG: signer command (shell command)
        //echo "hexDataToSign: <br/>";
        //var_dump($hexDataToSign);
        //echo "sig: <br/>";
        //var_dump($sig->getHex());

        return $sig;
    }

    /**
     * Array of signatures corresponding to all the data in tosign, typically provided by you.
     *
     * @param \string[] $signatures
     * @return $this
     */
    public function setSignatures($signatures)
    {
        $this->signatures = $signatures;
        return $this;
    }

    /**
     * @param $addresses
     * @param PrivateKeyList $privateKeyList
     * @return array
     */
    private function generatePubkeys($addresses, $privateKeyList)
    {
        $pubkeys = array();
        foreach ($addresses as $address) {
            $pubkeys[] = (string)$privateKeyList->getKey($address)->getPublicKey()->getHex();
        }
        return $pubkeys;
    }

    /**
     * Array of public keys corresponding to each signature.
     * In general, these are provided by you, and correspond to the signatures you provide.
     *
     * @param \string[] $pubkeys
     * @return $this
     */
    public function setPubkeys($pubkeys)
    {
        $this->pubkeys = $pubkeys;
        return $this;
    }

    /**
     * A temporary TX, usually returned fully filled but missing input scripts.
     *
     * @param \BlockCypher\Api\TX $tx
     * @return $this
     */
    public function setTx($tx)
    {
        $this->tx = $tx;
        return $this;
    }

    /**
     * Append Tosign to the list.
     *
     * @param string $tosign
     * @return $this
     */
    public function addTosign($tosign)
    {
        if (!$this->getTosign()) {
            return $this->setTosign(array($tosign));
        } else {
            return $this->setTosign(
                array_merge($this->getTosign(), array($tosign))
            );
        }
    }

    /**
     * Array of hex-encoded data for you to sign, one for each input.
     *
     * @param \string[] $tosign
     * @return $this
     */
    public function setTosign($tosign)
    {
        $this->tosign = $tosign;
        return $this;
    }

    /**
     * Remove Tosign from the list.
     *
     * @param string $tosign
     * @return $this
     */
    public function removeTosign($tosign)
    {
        return $this->setTosign(
            array_diff($this->getTosign(), array($tosign))
        );
    }

    /**
     * Append Signature to the list.
     *
     * @param string $signature
     * @return $this
     */
    public function addSignature($signature)
    {
        if (!$this->getSignatures()) {
            return $this->setSignatures(array($signature));
        } else {
            return $this->setSignatures(
                array_merge($this->getSignatures(), array($signature))
            );
        }
    }

    /**
     * Array of signatures corresponding to all the data in tosign, typically provided by you.
     *
     * @return \string[]
     */
    public function getSignatures()
    {
        return $this->signatures;
    }

    /**
     * Remove Signature from the list.
     *
     * @param string $signature
     * @return $this
     */
    public function removeSignature($signature)
    {
        return $this->setSignatures(
            array_diff($this->getSignatures(), array($signature))
        );
    }

    /**
     * Append Pubkey to the list.
     *
     * @param string $pubkey
     * @return $this
     */
    public function addPubkey($pubkey)
    {
        if (!$this->getPubkeys()) {
            return $this->setPubkeys(array($pubkey));
        } else {
            return $this->setPubkeys(
                array_merge($this->getPubkeys(), array($pubkey))
            );
        }
    }

    /**
     * Array of public keys corresponding to each signature.
     * In general, these are provided by you, and correspond to the signatures you provide.
     *
     * @return \string[]
     */
    public function getPubkeys()
    {
        return $this->pubkeys;
    }

    /**
     * Remove Pubkey from the list.
     *
     * @param string $pubkey
     * @return $this
     */
    public function removePubkey($pubkey)
    {
        return $this->setPubkeys(
            array_diff($this->getPubkeys(), array($pubkey))
        );
    }
}
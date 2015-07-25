<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Crypto\PrivateKeyList;
use BlockCypher\Crypto\Signer;
use BlockCypher\Exception\BlockCypherSignatureException;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class TXSkeleton
 *
 * A TXSkeleton is a convenience/wrapper Object that’s used primarily when Creating Transactions
 * through the New and Send endpoints.
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
     * Create a new transaction skeleton.
     *
     * @deprecated since version 1.2. Use TXClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/new",
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
     * Send the transaction to the network.
     *
     * @deprecated since version 1.2. Use TXClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return $this
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
     * Sign the transaction skeleton.
     *
     * @param string[]|string $privateKeys
     * @param string $coinSymbol
     * @return $this
     * @throws BlockCypherSignatureException
     */
    public function sign($privateKeys, $coinSymbol)
    {
        if (is_string($privateKeys)) {
            $privateKeys = array($privateKeys);
        }

        // Create PrivateKey objects from plain hex private keys
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($privateKeys, $coinSymbol);

        $this->generateSignatures($privateKeyList, $coinSymbol);

        return $this;
    }

    /**
     * @param PrivateKeyList $privateKeyList
     * @param string $coinSymbol
     * @throws BlockCypherSignatureException
     */
    private function generateSignatures($privateKeyList, $coinSymbol)
    {
        $signatures = array();
        $pubkeys = array();
        $tosignIndex = 0;

        $privateKeysUsed = array();

        foreach ($this->getTxInputs() as $txInput) {

            // Addresses can be network addresses or pubkeys (multisig txs)
            $txInputAddresses = $txInput->getAddresses();

            foreach ($txInputAddresses as $inputAddress) {

                if ($privateKeyList->privateKeyExists($inputAddress, $coinSymbol)) {

                    $privateKey = $privateKeyList->getPrivateKey($inputAddress, $coinSymbol);

                    // Signature
                    $hexDataToSign = $this->tosign[$tosignIndex];
                    $sig = Signer::sign($hexDataToSign, $privateKey);
                    $signatures[] = $sig;

                    // Pubkey
                    $pubKey = $privateKey->getPublicKey()->getHex();
                    $pubkeys[] = $pubKey;

                    $privateKeysUsed[] = $inputAddress;

                } else {
                    // User has not provide a private key for this address
                    // API allows to send partially signed tx
                    // TODO: add log?
                }
            }

            $tosignIndex++;
        }

        $numPrivateKeysNotUsed = $privateKeyList->length() - count($privateKeysUsed);
        if ($numPrivateKeysNotUsed > 0) {
            throw new BlockCypherSignatureException(sprintf("%s private keys do not correspond to any input. Please check private keys provided.", $numPrivateKeysNotUsed));
        }

        $this->signatures = $signatures;
        $this->pubkeys = $pubkeys;
    }

    private function getTxInputs()
    {
        return $this->getTx()->getInputs();
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
     * Return an array of all inputs addresses in the same order they are in the json tx skeleton
     * @return \string[]
     */
    public function getInputsAddresses()
    {
        $addresses = array();
        foreach ($this->getTx()->getInputs() as $txInput) {
            $inputAddresses = $txInput->getAddresses();
            if (is_array($inputAddresses)) {
                $addresses = array_merge($addresses, $inputAddresses);
            }
        }
        return $addresses;
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
     * @return \string[]
     */
    public function getTosign()
    {
        return $this->tosign;
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
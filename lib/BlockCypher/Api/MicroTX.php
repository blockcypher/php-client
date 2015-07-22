<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Crypto\Signer;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class TX
 *
 * A MicroTX represents a streamlined—and typically much lower value—microtransaction,
 * one which BlockCypher can sign for you if you send your private key.
 * MicroTXs can also be signed on the client-side without ever sending your private key.
 * You’ll find these objects used in the Microtransaction API.
 *
 * Only one of these three fields: from_pubkey, from_private, from_wif
 * is required for the microtransaction endpoint: from_pubkey, from_private, from_wif .
 * If you send more than one, the API will return an error.
 *
 * @package BlockCypher\Api
 *
 * @property string from_pubkey
 * @property string from_private
 * @property string from_wif
 * @property string to_address
 * @property int value_satoshis
 * @property string token
 * @property string change_address
 * @property bool wait_guarantee
 * @property string[] tosign
 * @property string[] signatures
 * @property \BlockCypher\Api\TXInput[] inputs
 * @property \BlockCypher\Api\TXInput[] outputs
 * @property int fees
 * @property string hash
 */
class MicroTX extends BlockCypherResourceModel
{
    /**
     * Send the microtransaction to the network.
     *
     * @deprecated since version 1.2. Use MicroTXClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function send($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/micro",
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
     * Signs MicroTX.
     *
     * @param string[]|string $hexPrivateKey
     * @return $this
     * @throws \Exception
     */
    public function sign($hexPrivateKey)
    {
        $this->setSignatures(Signer::signMultiple($this->tosign, $hexPrivateKey));
        return $this;
    }

    /**
     * Optional Hex-encoded signatures for you to send back after having received (and signed) tosign.
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
     * Create a new MicroTX.
     *
     * @deprecated since version 1.2. Use MicroTXClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/micro",
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
     * Hex-encoded public key from which you’re sending coins.
     *
     * @return string
     */
    public function getFromPubkey()
    {
        return $this->from_pubkey;
    }

    /**
     * Hex-encoded public key from which you’re sending coins.
     *
     * @param string $from_pubkey
     * @return $this
     */
    public function setFromPubkey($from_pubkey)
    {
        $this->from_pubkey = $from_pubkey;
        return $this;
    }

    /**
     * Hex-encoded private key from which you’re sending coins.
     *
     * @return string
     */
    public function getFromPrivate()
    {
        return $this->from_private;
    }

    /**
     * Hex-encoded private key from which you’re sending coins.
     *
     * @param string $from_private
     * @return $this
     */
    public function setFromPrivate($from_private)
    {
        $this->from_private = $from_private;
        return $this;
    }

    /**
     * WIF-encoded private key from which you’re sending coins.
     *
     * @return string
     */
    public function getFromWif()
    {
        return $this->from_wif;
    }

    /**
     * WIF-encoded private key from which you’re sending coins.
     *
     * @param string $from_wif
     * @return $this
     */
    public function setFromWif($from_wif)
    {
        $this->from_wif = $from_wif;
        return $this;
    }

    /**
     * The target address to which you’re sending coins.
     *
     * @return string
     */
    public function getToAddress()
    {
        return $this->to_address;
    }

    /**
     * The target address to which you’re sending coins.
     *
     * @param string $to_address
     * @return $this
     */
    public function setToAddress($to_address)
    {
        $this->to_address = $to_address;
        return $this;
    }

    /**
     * Value you’re sending/you’ve sent in satoshis.
     *
     * @return int
     */
    public function getValueSatoshis()
    {
        return $this->value_satoshis;
    }

    /**
     * Value you’re sending/you’ve sent in satoshis.
     *
     * @param int $value_satoshis
     * @return $this
     */
    public function setValueSatoshis($value_satoshis)
    {
        $this->value_satoshis = $value_satoshis;
        return $this;
    }

    /**
     * Your BlockCypher API token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Your BlockCypher API token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Optional Address BlockCypher will use to send back your change. If not set, defaults to the address
     * from which the coins were originally sent. While not required, we recommend that you set a change address.
     * @return string
     */
    public function getChangeAddress()
    {
        return $this->change_address;
    }

    /**
     * Optional Address BlockCypher will use to send back your change. If not set, defaults to the address
     * from which the coins were originally sent. While not required, we recommend that you set a change address.
     *
     * @param string $change_address
     * @return $this
     */
    public function setChangeAddress($change_address)
    {
        $this->change_address = $change_address;
        return $this;
    }

    /**
     * Optional If not set, defaults to true, which means the API will wait for BlockCypher to guarantee
     * the transaction, using our Confidence Factor. The guarantee usually takes around 8 seconds.
     * If manually set to false, the Microtransaction endpoint will return as soon as the transaction is broadcast.
     *
     * @return boolean
     */
    public function isWaitGuarantee()
    {
        return $this->wait_guarantee;
    }

    /**
     * Optional If not set, defaults to true, which means the API will wait for BlockCypher to guarantee
     * the transaction, using our Confidence Factor. The guarantee usually takes around 8 seconds.
     * If manually set to false, the Microtransaction endpoint will return as soon as the transaction is broadcast.
     *
     * @return bool
     */
    public function getWaitGuarantee()
    {
        return $this->wait_guarantee;
    }

    /**
     * Optional If not set, defaults to true, which means the API will wait for BlockCypher to guarantee
     * the transaction, using our Confidence Factor. The guarantee usually takes around 8 seconds.
     * If manually set to false, the Microtransaction endpoint will return as soon as the transaction is broadcast.
     *
     * @param boolean $wait_guarantee
     * @return $this
     */
    public function setWaitGuarantee($wait_guarantee)
    {
        $this->wait_guarantee = $wait_guarantee;
        return $this;
    }

    /**
     * Optional Hex-encoded data for you to sign after initiating the microtransaction.
     * Sent in reply to a microtransaction generated using from_pubkey/a public key.
     *
     * @return \string[]
     */
    public function getTosign()
    {
        return $this->tosign;
    }

    /**
     * Optional Hex-encoded data for you to sign after initiating the microtransaction.
     * Sent in reply to a microtransaction generated using from_pubkey/a public key.
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
     * Optional Hex-encoded signatures for you to send back after having received (and signed) tosign.
     *
     * @return \string[]
     */
    public function getSignatures()
    {
        return $this->signatures;
    }

    /**
     * Optional Partial list of inputs that will be used with this transaction. Only returned when using from_pubkey.
     *
     * @return \BlockCypher\Api\TXInput[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Optional Partial list of inputs that will be used with this transaction. Only returned when using from_pubkey.
     *
     * @param \BlockCypher\Api\TXInput[] $inputs
     * @return $this
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * Optional Partial list of outputs that will be used with this transaction. Only returned when using from_pubkey.
     *
     * @return \BlockCypher\Api\TXOutput[]
     */
    public function getOutputs()
    {
        return $this->outputs;
    }

    /**
     * Optional Partial list of outputs that will be used with this transaction. Only returned when using from_pubkey.
     *
     * @param \BlockCypher\Api\TXOutput[] $outputs
     * @return $this
     */
    public function setOutputs($outputs)
    {
        $this->outputs = $outputs;
        return $this;
    }

    /**
     * Optional BlockCypher’s optimally calculated fees for this MicroTX to guarantee swift 99% confirmation,
     * only returned when using from_pubkey. BlockCypher pays these fees for the first 8,000 microtransactions,
     * but like regular transactions, it is deducted from the source address thereafter.
     *
     * @return int
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Optional BlockCypher’s optimally calculated fees for this MicroTX to guarantee swift 99% confirmation,
     * only returned when using from_pubkey. BlockCypher pays these fees for the first 8,000 microtransactions,
     * but like regular transactions, it is deducted from the source address thereafter.
     *
     * @param int $fees
     * @return $this
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
        return $this;
    }

    /**
     * Optional The hash of the finalized transaction, once sent
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Optional The hash of the finalized transaction, once sent
     *
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }
}
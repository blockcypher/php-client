<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class PaymentForwardCallback
 *
 * A PaymentForwardCallback object represents the payload delivered to the optional callback_url in a
 * PaymentForward request.
 *
 * @package BlockCypher\Api
 *
 * @property int value
 * @property string input_address
 * @property string destination
 * @property string input_transaction_hash
 * @property string transaction_hash
 */
class PaymentForwardCallback extends BlockCypherBaseModel
{
    /**
     * Amount sent to the destination address, in satoshis.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Amount sent to the destination address, in satoshis.
     *
     * @param int $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * The transaction hash of the generated transaction that forwards the payment from the input_address to
     * the destination.
     *
     * @return string
     */
    public function getTransactionHash()
    {
        return $this->transaction_hash;
    }

    /**
     * The transaction hash of the generated transaction that forwards the payment from the input_address to
     * the destination.
     *
     * @param string $transaction_hash
     * @return $this
     */
    public function setTransactionHash($transaction_hash)
    {
        $this->transaction_hash = $transaction_hash;
        return $this;
    }

    /**
     * The transaction hash representing the initial payment to the input_address.
     *
     * @return string
     */
    public function getInputTransactionHash()
    {
        return $this->input_transaction_hash;
    }

    /**
     * The transaction hash representing the initial payment to the input_address.
     *
     * @param string $input_transaction_hash
     * @return $this
     */
    public function setInputTransactionHash($input_transaction_hash)
    {
        $this->input_transaction_hash = $input_transaction_hash;
        return $this;
    }

    /**
     * The final destination address to which the payment will eventually be sent.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * The final destination address to which the payment will eventually be sent.
     *
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * The intermediate address to which the payment was originally sent.
     *
     * @return string
     */
    public function getInputAddress()
    {
        return $this->input_address;
    }

    /**
     * The intermediate address to which the payment was originally sent.
     *
     * @param string $input_address
     * @return $this
     */
    public function setInputAddress($input_address)
    {
        $this->input_address = $input_address;
        return $this;
    }
}
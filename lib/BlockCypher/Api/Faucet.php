<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentValidator;
use BlockCypher\Validation\NumericValidator;

/**
 * Class Faucet
 *
 * A resource representing a block.
 *
 * @package BlockCypher\Api
 *
 * @property string address
 * @property int amount
 */
class Faucet extends BlockCypherResourceModel
{
    /**
     * Fund an address with faucet.
     * The faucet endpoint is only available on BlockCypher’s Test Blockchain and Bitcoin Testnet3
     *
     * @param string $address Address to fund
     * @param int $amount
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FaucetResponse
     */
    public static function fundAddress($address, $amount, $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        NumericValidator::validate($amount, 'amount');

        $faucet = new self();
        $faucet->setAddress($address);
        $faucet->setAmount($amount);

        return $faucet->turnOn($apiContext, $restCall);
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Fund an address with faucet.
     * The faucet endpoint is only available on BlockCypher’s Test Blockchain and Bitcoin Testnet3
     *
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FaucetResponse
     */
    public function turnOn($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/faucet",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new FaucetResponse();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
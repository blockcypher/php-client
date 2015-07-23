<?php

namespace BlockCypher\Client;

use BlockCypher\Api\Faucet;
use BlockCypher\Api\FaucetResponse;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentValidator;
use BlockCypher\Validation\NumericValidator;

/**
 * Class FaucetClient
 *
 * @package BlockCypher\Client
 *
 */
class FaucetClient extends BlockCypherClient
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
    public function fundAddress($address, $amount, $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        NumericValidator::validate($amount, 'amount');

        $faucet = new Faucet();
        $faucet->setAddress($address);
        $faucet->setAmount($amount);

        return $this->turnOn($faucet, $apiContext, $restCall);
    }

    /**
     * Fund an address with faucet.
     * The faucet endpoint is only available on BlockCypher’s Test Blockchain and Bitcoin Testnet3
     *
     * @param Faucet $faucet
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FaucetResponse
     */
    public function turnOn(Faucet $faucet, $apiContext = null, $restCall = null)
    {
        $payLoad = $faucet->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
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
}
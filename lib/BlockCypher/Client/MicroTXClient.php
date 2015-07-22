<?php

namespace BlockCypher\Client;

use BlockCypher\Api\MicroTX;
use BlockCypher\Builder\MicroTXBuilder;
use BlockCypher\Crypto\PrivateKeyManipulator;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class MicroTXClient
 *
 * @package BlockCypher\Client
 *
 */
class MicroTXClient extends BlockCypherClient
{
    /**
     * Send a microtransaction signing it locally (without sending the private key to the server)
     *
     * @param string $hexPrivateKey
     * @param string $toAddress
     * @param int $valueSatoshis
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function sendSigned($hexPrivateKey, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $compressed = true;
        $pubkey = PrivateKeyManipulator::generateHexPubKeyFromHexPrivKey($hexPrivateKey, $compressed);

        $microTX = MicroTXBuilder::newMicroTX()
            ->fromPubkey($pubkey)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build();

        $microTX = $this->create($microTX, $apiContext, $restCall);
        $microTX->sign($hexPrivateKey);
        $microTX = $this->send($microTX, $apiContext, $restCall);

        return $microTX;
    }

    /**
     * Create a new MicroTX.
     *
     * @param MicroTX $microTX
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function create(MicroTX $microTX, $apiContext = null, $restCall = null)
    {
        $payLoad = $microTX->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/micro",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $microTX->fromJson($json);
        return $microTX;
    }

    /**
     * Send the microtransaction to the network.
     *
     * @param MicroTX $microTX
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function send(MicroTX $microTX, $apiContext = null, $restCall = null)
    {
        $payLoad = $microTX->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/micro",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $microTX->fromJson($json);
        return $microTX;
    }

    /**
     * Send a microtransaction signing it on server side (sending the private key to the server)
     *
     * @param string $hexPrivateKey
     * @param string $toAddress
     * @param int $valueSatoshis
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function sendWithPrivateKey($hexPrivateKey, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $microTX = MicroTXBuilder::newMicroTX()
            ->fromPrivate($hexPrivateKey)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build();

        $microTX = $this->create($microTX, $apiContext, $restCall);

        return $microTX;
    }

    /**
     * Send a microtransaction signing it on server side (sending the private key to the server).
     * Same functionality as fromPrivate method but using WIF format for private key.
     *
     * @param string $wif
     * @param string $toAddress
     * @param int $valueSatoshis
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return MicroTX
     */
    public function sendWithWif($wif, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $microTX = MicroTXBuilder::newMicroTX()
            ->fromWif($wif)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build();

        $microTX = $this->create($microTX, $apiContext, $restCall);

        return $microTX;
    }
}
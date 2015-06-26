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
class MicroTXClient
{
    // TODO: Code Review. Remove $apiContext and $restCall from methods and add them to constructor
    // and use the Client with an instance not static methods?

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
    public static function sendSigned($hexPrivateKey, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $compressed = true;
        $pubkey = PrivateKeyManipulator::generateHexPubKeyFromHexPrivKey($hexPrivateKey, $compressed);

        $microTX = MicroTXBuilder::aMicroTX()
            ->fromPubkey($pubkey)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build()
            ->create($apiContext, $restCall)
            ->sign($hexPrivateKey)
            ->send($apiContext, $restCall);

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
    public static function sendWithPrivateKey($hexPrivateKey, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $microTX = MicroTXBuilder::aMicroTX()
            ->fromPrivate($hexPrivateKey)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build()
            ->create($apiContext, $restCall);

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
    public static function sendWithWif($wif, $toAddress, $valueSatoshis, $apiContext = null, $restCall = null)
    {
        $microTX = MicroTXBuilder::aMicroTX()
            ->fromWif($wif)
            ->toAddress($toAddress)
            ->withValueInSatoshis($valueSatoshis)
            ->build()
            ->create($apiContext, $restCall);

        return $microTX;
    }
}
<?php

namespace BlockCypher\Crypto;

use BitWasp\Bitcoin\Network\NetworkFactory;

/**
 * Class CoinSymbolNetworkMapping
 * @package BlockCypher\Crypto
 */
class CoinSymbolNetworkMapping
{
    /**
     * @param $coinSymbol
     * @return \BitWasp\Bitcoin\Network\Network
     * @throws \Exception
     */
    public static function getNetwork($coinSymbol)
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
}
<?php

namespace BlockCypher\Crypto;

use BitWasp\Bitcoin\Network\NetworkFactory;
use BlockCypher\Validation\CoinSymbolValidator;

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
        CoinSymbolValidator::validate($coinSymbol, 'coinSymbol');

        $network = null;

        switch ($coinSymbol) {
            case 'btc':
                $network = NetworkFactory::bitcoin();
                break;
            case 'btc-testnet':
                $network = NetworkFactory::bitcoinTestnet();
                break;
            case 'ltc':
                $network = NetworkFactory::litecoin();
                break;
            case 'doge':
                //$network = NetworkFactory::dogecoin();
                throw new \Exception("Unsupported coin symbol: $coinSymbol by php-client");
                break;
            case 'uro':
                //$network = NetworkFactory::uro();
                throw new \Exception("Unsupported coin symbol: $coinSymbol by php-client");
                break;
            case 'bcy':
                //$network = NetworkFactory::BlockCypherTestnet();
                throw new \Exception("Unsupported coin symbol: $coinSymbol by php-client");
                break;
            default:
                throw new \Exception("Unsupported coin symbol: $coinSymbol");
        }

        return $network;
    }
}
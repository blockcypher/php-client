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
                $network = NetworkFactory::create('1e', '16', '9e')
                    ->setHDPubByte('02fd3929')
                    ->setHDPrivByte('02fd3955')
                    ->setNetMagicBytes('c0c0c0c0');
                break;
            case 'uro':
                // NetMagicBytes: https://github.com/urocoin/uro/blob/319de97bbd56a10a3b2dca5b36be0c7a9c6603ae/src/main.cpp#L3233
                throw new \Exception("Unsupported coin symbol: $coinSymbol");
                break;
            case 'bcy':
                // TODO: check ef, 043587cf, 04358394, d9b4bef9 values
                // not used for the time being
                $network = NetworkFactory::create('1b', '1f', 'ef', true)
                    ->setHDPubByte('043587cf')
                    ->setHDPrivByte('04358394')
                    ->setNetMagicBytes('d9b4bef9');
                break;
            default:
                throw new \Exception("Unsupported coin symbol: $coinSymbol by php-client");
        }

        return $network;
    }
}
<?php

namespace BlockCypher\Crypto;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Random\Rfc6979;
use BitWasp\Bitcoin\Key\PrivateKeyInterface;
use BitWasp\Buffertools\Buffer;
use BlockCypher\Validation\ArgumentArrayValidator;

/**
 * Class Signer
 * @package BlockCypher\Crypto
 */
class Signer
{
    /**
     * Sign array of hex data deterministically using deterministic k.
     *
     * @param string[] $hexDataToSign
     * @param PrivateKeyInterface|string $privateKey
     * @return string[]
     */
    public static function signMultiple($hexDataToSign, $privateKey)
    {
        ArgumentArrayValidator::validate($hexDataToSign, 'hexDataToSign');

        $signatures = array();
        foreach ($hexDataToSign as $tosign) {
            $signatures[] = self::sign($tosign, $privateKey);
        }
        return $signatures;
    }

    /**
     * Sign hex data deterministically using deterministic k.
     *
     * @param string $hexDataToSign
     * @param PrivateKeyInterface|string $privateKey
     * @return string
     */
    public static function sign($hexDataToSign, $privateKey)
    {
        if (is_string($privateKey)) {
            $privateKey = PrivateKeyManipulator::importPrivateKey($privateKey);
        }

        // Convert hex data to buffer
        $data = Buffer::hex($hexDataToSign);

        /** @var EcAdapterInterface $ecAdapter */
        $ecAdapter = Bitcoin::getEcAdapter();

        // Deterministic digital signature generation
        $k = new Rfc6979($ecAdapter, $privateKey, $data, 'sha256');

        $sig = $ecAdapter->sign($data, $privateKey, $k);

        // DEBUG
        //echo "hexDataToSign: <br/>";
        //var_dump($hexDataToSign);
        //echo "sig: <br/>";
        //var_dump($sig->getHex());

        return $sig->getHex();
    }
}
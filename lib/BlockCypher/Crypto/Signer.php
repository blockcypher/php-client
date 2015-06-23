<?php

namespace BlockCypher\Crypto;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcAdapterInterface;
use BitWasp\Bitcoin\Crypto\Random\Rfc6979;
use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\PrivateKeyInterface;
use BitWasp\Buffertools\Buffer;

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
        if (!is_array($hexDataToSign)) {
            throw new \InvalidArgumentException("Signer::signMultiple, param hexDataToSign must be an array");
        }

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
            $privateKey = self::importPrivateKey($privateKey);
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

    /**
     * @param string $plainPrivateKey
     * @return PrivateKeyInterface
     */
    public static function importPrivateKey($plainPrivateKey)
    {
        $privateKey = null;
        $extraMsg = '';

        // TODO: Code Review. Method to detect private key format.

        if ($privateKey === null) {
            try {
                $privateKey = PrivateKeyFactory::fromWif($plainPrivateKey);
            } catch (\Exception $e) {
                $extraMsg .= " Error trying to import from Wif: " . $e->getMessage();
            }
        }

        if ($privateKey === null) {
            try {
                $privateKey = PrivateKeyFactory::fromHex($plainPrivateKey);
            } catch (\Exception $e) {
                $extraMsg .= " Error trying to import from Hex: " . $e->getMessage();
            }
        }

        if ($privateKey === null) {
            throw new \InvalidArgumentException("Invalid private key format. " . $extraMsg);
        }

        return $privateKey;
    }

    /**
     * @param string $hexPrivateKey
     * @return PrivateKeyInterface
     * @throws \Exception
     */
    public static function importPrivateKeyFromHex($hexPrivateKey)
    {
        // Import from compressed private key
        $compressed = true;
        $privateKey = PrivateKeyFactory::fromHex($hexPrivateKey, $compressed);

        return $privateKey;
    }

    /**
     * @param string $wifPrivateKey
     * @return PrivateKeyInterface
     * @throws \Exception
     */
    public static function importPrivateKeyFromWif($wifPrivateKey)
    {
        $privateKey = PrivateKeyFactory::fromWif($wifPrivateKey);

        return $privateKey;
    }
}
<?php

namespace BlockCypher\Crypto;

use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\CoinSymbolValidator;

/**
 * Class PrivateKeyList
 * @package BlockCypher\Crypto
 */
class PrivateKeyList
{
    /**
     * @var PrivateKey[]
     */
    private $privateKeys;

    function __construct()
    {
        $this->privateKeys = array();
    }

    /**
     * @param string[] $hexPrivateKeys
     * @param string
     * @param bool $compressed True if the public key should be using compressed format
     * @return PrivateKeyList
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public static function fromHexPrivateKeyArray($hexPrivateKeys, $coinSymbol, $compressed=true)
    {
        ArgumentArrayValidator::validate($hexPrivateKeys, 'hexPrivateKeys');
        CoinSymbolValidator::validate($coinSymbol, 'coinSymbol');

        $privateKeyList = new self($coinSymbol);

        foreach ($hexPrivateKeys as $hexPrivateKey) {
            $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($hexPrivateKey, $compressed);

            // Add private key indexed by public key
            $privateKeyList->addPrivateKey($privateKey);
        }
        return $privateKeyList;
    }

    /**
     * Append private key to the list.
     *
     * @param PrivateKeyInterface $privateKey
     * @return $this
     */
    public function addPrivateKey(PrivateKeyInterface $privateKey)
    {
        $pubKeyHex = $privateKey->getPublicKey()->getHex();
        $this->privateKeys[$pubKeyHex] = $privateKey;
    }

    /**
     * @param string $addressOrPublicKey
     * @param string $coinSymbol
     * @return PrivateKey|null
     */
    public function getPrivateKey($addressOrPublicKey, $coinSymbol)
    {
        $privateKey = $this->getPrivateKeyByPublicKey($addressOrPublicKey);
        if ($privateKey !== null) {
            return $privateKey;
        }

        $privateKey = $this->getPrivateKeyByAddress($addressOrPublicKey, $coinSymbol);
        if ($privateKey !== null) {
            return $privateKey;
        }

        return null;
    }

    /**
     * @param $publicKeyHex
     * @return PrivateKey|null
     */
    private function getPrivateKeyByPublicKey($publicKeyHex)
    {
        if (isset($this->privateKeys[$publicKeyHex])) {
            return $this->privateKeys[$publicKeyHex];
        } else {
            return null;
        }
    }

    /**
     * @param string $addressToFind
     * @param $coinSymbol
     * @return PrivateKey|null
     */
    private function getPrivateKeyByAddress($addressToFind, $coinSymbol)
    {
        foreach ($this->privateKeys as $privateKey) {
            $address = PrivateKeyManipulator::getAddressFromPrivateKey($privateKey, $coinSymbol);
            if ($address == $addressToFind) {
                return $privateKey;
            }
        }
        return null;
    }

    /**
     * @param string $addressOrPublicKey
     * @param string $coinSymbol
     * @return bool
     */
    public function privateKeyExists($addressOrPublicKey, $coinSymbol)
    {
        if ($this->privateKeyExistsForPubKey($addressOrPublicKey)) {
            return true;
        }

        if ($this->privateKeyExistsForAddress($addressOrPublicKey, $coinSymbol)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $addressOrPublicKey
     * @param string $coinSymbol
     * @return bool
     */
    public function containsPrivateKeyFor($addressOrPublicKey, $coinSymbol)
    {
        return $this->privateKeyExists($addressOrPublicKey, $coinSymbol);
    }

    /**
     * @param string $pubKeyHex
     * @return bool
     */
    private function privateKeyExistsForPubKey($pubKeyHex)
    {
        if ($this->getPrivateKeyByPublicKey($pubKeyHex) !== null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $addressToFind
     * @param $coinSymbol
     * @return bool
     */
    private function privateKeyExistsForAddress($addressToFind, $coinSymbol)
    {
        if ($this->getPrivateKeyByAddress($addressToFind, $coinSymbol) !== null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return PrivateKey[]
     */
    public function getPrivateKeys()
    {
        return $this->privateKeys;
    }

    /**
     * @return string[]
     */
    public function getPublicKeys()
    {
        return array_keys($this->privateKeys);
    }

    /**
     * @param string $coinSymbol
     * @return \string[]
     */
    public function getAddresses($coinSymbol)
    {
        $addresses = array();
        foreach ($this->privateKeys as $privateKey) {
            $address = PrivateKeyManipulator::getAddressFromPrivateKey($privateKey, $coinSymbol);
            $addresses[] = $address;
        }
        return $addresses;
    }

    /**
     * @return int
     */
    public function length()
    {
        return count($this->privateKeys);
    }
}

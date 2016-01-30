<?php

namespace BlockCypher\Test\Crypto;

use BitWasp\Bitcoin\Key\PrivateKeyInterface;
use BlockCypher\Crypto\PrivateKeyList;
use BlockCypher\Crypto\PrivateKeyManipulator;

/**
 * Class PrivateKeyListTest
 * @package BlockCypher\Test\Crypto
 */
class PrivateKeyListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $address
     */
    public function testFromHexPrivateKeyArray($address)
    {
        $hexPrivateKeyArray = array($address['private']);

        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, $address['coinSymbol'], $address['compressed']);

        $this->assertArrayHasKey($address['public'], $privateKeyList->getPrivateKeys());
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     */
    public function testFromHexPrivateKeyArrayWithDifferentCoinSymbol($address)
    {
        $hexPrivateKeyArray = array($address['private']);
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'doge', $address['compressed']);

        $this->assertArrayHasKey($address['public'], $privateKeyList->getPrivateKeys());
    }

    /**
     * @dataProvider dataProvider
     * @expectedException \InvalidArgumentException
     * @param $address
     */
    public function testFromHexPrivateKeyArrayWithInvalidCoinSymbol($address)
    {
        $hexPrivateKeyArray = array($address['private']);
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'INVALID-COIN-SYMBOL', $address['compressed']);

        $this->assertEmpty($privateKeyList->getPrivateKeys());
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testAddPrivateKey($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->anEmptyPrivateKeyList();

        $privateKeyList->addPrivateKey($privateKey);

        $this->assertContains($privateKey, $privateKeyList->getPrivateKeys());
    }

    /**
     * @return PrivateKeyList
     */
    public function anEmptyPrivateKeyList()
    {
        return new PrivateKeyList();
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testGetPrivateKey($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        $this->assertEquals($privateKey, $privateKeyList->getPrivateKey($address['public'], $address['coinSymbol']));
        $this->assertEquals($privateKey, $privateKeyList->getPrivateKey($address['address'], $address['coinSymbol']));
    }

    /**
     * @param PrivateKeyInterface $privateKey
     * @return PrivateKeyList
     */
    public function aPrivateKeyListWithOne(PrivateKeyInterface $privateKey)
    {
        $privateKeyList = new PrivateKeyList();
        $privateKeyList->addPrivateKey($privateKey);
        return $privateKeyList;
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testPrivateKeyExists($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        // Find by public key
        $this->assertTrue($privateKeyList->privateKeyExists($address['public'], $address['coinSymbol']));
        // Find by address
        $this->assertTrue($privateKeyList->privateKeyExists($address['address'], $address['coinSymbol']));
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testContainsPrivateKeyFor($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        // Find by public key
        $this->assertTrue($privateKeyList->containsPrivateKeyFor($address['public'], $address['coinSymbol']));
        // Find by address
        $this->assertTrue($privateKeyList->containsPrivateKeyFor($address['address'], $address['coinSymbol']));
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testGetPrivateKeys($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        $this->assertEquals(array($address['public'] => $privateKey), $privateKeyList->getPrivateKeys());
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testAddresses($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        $this->assertEquals(array($address['address']), $privateKeyList->getAddresses($address['coinSymbol']));
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     * @throws \BlockCypher\Exception\BlockCypherInvalidPrivateKeyException
     */
    public function testLength($address)
    {
        $privateKeyList = $this->anEmptyPrivateKeyList();
        $this->assertEquals(0, $privateKeyList->length());

        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);
        $this->assertEquals(1, $privateKeyList->length());
    }

    public function dataProvider()
    {
        $btcAddress = array(
            'coinSymbol'    => 'btc',
            'compressed'    => true,
            'private'       => '264f692826e03a0c92f5821063d316ed666b941fd5b524f0915896b6c6585fae',
            'public'        => '0222e045d6c73eaeb859caa5721e0757159c3513d74bc1f363e2f0bfc3f519e2c0',
            'address'       => '12aWoA8ZETnKBgrWRF13VRQRqBbephS7Qf',
            'wif'           => 'KxWBSoYSpEwUMYPpL44cy5JYmik6Btq45waGVocfTPK5b2PvQsJ3'
        );

        $btcPublicUncompressedAddress = array(
            'coinSymbol'    => 'btc',
            'compressed'    => false,
            'private'       => '264f692826e03a0c92f5821063d316ed666b941fd5b524f0915896b6c6585fae',
            'public'        => '0422e045d6c73eaeb859caa5721e0757159c3513d74bc1f363e2f0bfc3f519e2c02d38c33024f1bafb3a229d8497acd53c04aacc99d7902cc2c47ed364730faefc',
            'address'       => '14K2dNSgHDEsK2EFDS5P9qFEEK8jyQoGK4',
            'wif'           => '5J7AAUJzxZcT8ptqnYxebudbqeYy1Ck4REGhDR9zCR618jq5YGG',
        );

        $btcTest3Address = array(
            'coinSymbol'    => 'btc-testnet',
            'compressed'    => true,
            'private'       => 'd4269a38cac9fb340d13b2e9b6f56d38d3864b705efabd538f4778df88d6caeb',
            'public'        => '031199c92b70ab127c9d12fcfd3e366342fe615427e551d90715895513cc7d7bc9',
            'address'       => 'n1F6ryEcx1aM6TKqrM7vAtWunWsKuxZ6Hs',
            'wif'           => 'cUh6U224smkjRX4z1XQwYaQLSTzGDJvVk4gEsTAiBb7RJANmDMmj',
        );

        $btcTestPublicUncompressedAddress = array(
            'coinSymbol'    => 'btc-testnet',
            'compressed'    => false,
            'private'       => 'd4269a38cac9fb340d13b2e9b6f56d38d3864b705efabd538f4778df88d6caeb',
            'public'        => '041199c92b70ab127c9d12fcfd3e366342fe615427e551d90715895513cc7d7bc91f94f98fca95c72b0ec2b9892966c54c266edfde399ff272d479cb4dd9c0ad41',
            'address'       => 'mttFNoZ6a3k2g52xpuQ9krdMBDvjRMr9Uq',
            'wif'           => '93CMGdwAVGaUHRwNXUjaey42EUQrDJewznhA2v47ACMVAMWZyiz',
        );

        return array(
            array($btcAddress),
            array($btcPublicUncompressedAddress),
            array($btcTest3Address),
            array($btcTestPublicUncompressedAddress),
        );
    }
}
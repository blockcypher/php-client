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

        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, $address['coinSymbol']);

        $this->assertArrayHasKey($address['public'], $privateKeyList->getPrivateKeys());
    }

    /**
     * @dataProvider dataProvider
     * @param $address
     */
    public function testFromHexPrivateKeyArrayWithDifferentCoinSymbol($address)
    {
        $hexPrivateKeyArray = array($address['private']);
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'doge');

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
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'INVALID-COIN-SYMBOL');

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

        $privateKeyList->addPrivateKey($privateKey, $address['coinSymbol']);

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

        // DEBUG
        //var_export($address);
        //var_export($privateKey);
        //var_dump($privateKeyList->getPrivateKey($address['public'], $address['coinSymbol']));
        //die();

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
    public function testKeyExists($address)
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex($address['private'], $address['compressed']);
        $privateKeyList = $this->aPrivateKeyListWithOne($privateKey);

        $this->assertTrue($privateKeyList->privateKeyExists($address['public'], $address['coinSymbol']));
        $this->assertTrue($privateKeyList->privateKeyExists($address['address'], $address['coinSymbol']));
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
        $addressBtc = array();
        $addressBtc['coinSymbol'] = 'btc';
        $addressBtc['compressed'] = true;
        $addressBtc['private'] = '264f692826e03a0c92f5821063d316ed666b941fd5b524f0915896b6c6585fae';
        $addressBtc['public'] = '0222e045d6c73eaeb859caa5721e0757159c3513d74bc1f363e2f0bfc3f519e2c0';
        $addressBtc['address'] = '12aWoA8ZETnKBgrWRF13VRQRqBbephS7Qf';
        $addressBtc['wif'] = 'KxWBSoYSpEwUMYPpL44cy5JYmik6Btq45waGVocfTPK5b2PvQsJ3';

        $addressBtcTest3 = array();
        $addressBtcTest3['coinSymbol'] = 'btc-testnet';
        $addressBtcTest3['compressed'] = true;
        $addressBtcTest3['private'] = 'd4269a38cac9fb340d13b2e9b6f56d38d3864b705efabd538f4778df88d6caeb';
        $addressBtcTest3['public'] = '031199c92b70ab127c9d12fcfd3e366342fe615427e551d90715895513cc7d7bc9';
        $addressBtcTest3['address'] = 'n1F6ryEcx1aM6TKqrM7vAtWunWsKuxZ6Hs';
        $addressBtcTest3['wif'] = 'cUh6U224smkjRX4z1XQwYaQLSTzGDJvVk4gEsTAiBb7RJANmDMmj';

        return array(
            array($addressBtc),
            array($addressBtcTest3),
        );
    }
}
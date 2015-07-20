<?php

namespace BlockCypher\Test\Crypto;

use BlockCypher\Crypto\PrivateKeyList;

/**
 * Class PrivateKeyListTest
 * @package BlockCypher\Test\Crypto
 */
class PrivateKeyListTest extends \PHPUnit_Framework_TestCase
{
    public function testFromHexPrivateKeyArray()
    {
        $hexPrivateKeyArray = array("1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e");

        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'btc-testnet');

        $this->assertArrayHasKey("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4", $privateKeyList->getKeys());
        $this->assertArrayHasKey("0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf", $privateKeyList->getKeys());
    }

    public function testFromHexPrivateKeyArrayWithDifferentCoinSymbol()
    {
        $hexPrivateKeyArray = array("1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e");
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'btc');

        $this->assertArrayNotHasKey("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4", $privateKeyList->getKeys());
        $this->assertArrayHasKey("0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf", $privateKeyList->getKeys());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromHexPrivateKeyArrayWithInvalidCoinSymbol()
    {
        $hexPrivateKeyArray = array("1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e");
        $privateKeyList = PrivateKeyList::fromHexPrivateKeyArray($hexPrivateKeyArray, 'INVALID-COIN-SYMBOL');

        $this->assertEmpty($privateKeyList->getKeys());
    }

    public function testAddKey()
    {
        $privateKey = $this->getPrivateKeyMockForAddress();
        $privateKeyList = $this->anEmptyPrivateKeyList();

        $privateKeyList->addKey($privateKey, "C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm");

        $this->assertContains($privateKey, $privateKeyList->getKeys());
    }

    public function getPrivateKeyMockForAddress()
    {
        $privateKey = $this->getMockBuilder('\BitWasp\Bitcoin\Key\PrivateKey')
            ->disableOriginalConstructor()
            ->getMock();

        return $privateKey;
    }

    public function anEmptyPrivateKeyList()
    {
        return new PrivateKeyList();
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     * @throws \Exception
     */
    public function testDeleteKey($address, $privateKey, $privateKeyList)
    {
        $privateKeyList->deleteKey($address);

        $this->assertNotContains($privateKey, $privateKeyList->getKeys());
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     */
    public function testGetKey($address, $privateKey, $privateKeyList)
    {
        $result = $privateKeyList->getKey($address);

        $this->assertEquals($privateKey, $result);
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     */
    public function testKeyExists($address, $privateKey, $privateKeyList)
    {
        $this->assertTrue($privateKeyList->keyExists($address));
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     */
    public function testGetKeys($address, $privateKey, $privateKeyList)
    {
        $result = $privateKeyList->getKeys();

        $this->assertEquals(array($address => $privateKey), $result);
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     */
    public function testAddresses($address, $privateKey, $privateKeyList)
    {
        $result = $privateKeyList->addresses();

        $this->assertEquals(array($address), $result);
    }

    /**
     * @dataProvider mockProvider
     * @param $address
     * @param $privateKey
     * @param PrivateKeyList $privateKeyList
     */
    public function testLength($address, $privateKey, $privateKeyList)
    {
        $this->assertEquals(1, $privateKeyList->length());
    }

    public function mockProvider()
    {
        $address = "C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm";
        $privateKey = $this->getPrivateKeyMockForAddress();
        $privateKeyList = $this->aPrivateKeyListWith($privateKey, $address);

        return array(
            array($address, $privateKey, $privateKeyList)
        );
    }

    public function aPrivateKeyListWith($privateKey, $address)
    {
        return new PrivateKeyList(array($address => $privateKey));
    }
}
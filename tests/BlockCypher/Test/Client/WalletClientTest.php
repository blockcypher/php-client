<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\WalletClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\AddressListTest;
use BlockCypher\Test\Api\WalletGenerateAddressResponseTest;
use BlockCypher\Test\Api\WalletTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class WalletClientTest
 *
 * @package BlockCypher\Test\Client
 */
class WalletClientTest extends ClientTestCase
{
    /**
     * @return WalletClient
     */
    public static function getObject()
    {
        return new WalletClient();
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson()
            ));

        $result = $obj->create(WalletTest::getObject(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGenerateAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletGenerateAddressResponseTest::getJson()
            ));

        $result = $obj->generateAddress(WalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testAddAddresses($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $addressList = AddressListTest::getObject();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson(array_merge(WalletTest::addresses(), $addressList->getAddresses()))
            ));

        $result = $obj->addAddresses(WalletTest::getObject()->getName(), $addressList, array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        foreach ($addressList->getAddresses() as $address) {
            $this->assertContains($address, $result->getAddresses());
        }
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testRemoveAddresses($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $addressList = AddressListTest::getObject();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson(array_diff(WalletTest::addresses(), $addressList->getAddresses()))
            ));

        $result = $obj->addAddresses(WalletTest::getObject()->getName(), $addressList, array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        $this->assertNotContains($addressList->getAddresses(), $result->getAddresses());
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGet($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson()
            ));

        $result = $obj->get(WalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultiple($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . WalletTest::getJson() . ']'
            ));

        $walletList = array(WalletTest::getObject()->getName());

        $result = $obj->getMultiple($walletList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], WalletTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWalletAddresses($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressListTest::getJson()
            ));

        $result = $obj->getWalletAddresses(WalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetOnlyAddresses($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressListTest::getJson()
            ));

        $result = $obj->getOnlyAddresses(WalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     */
    public function testGetParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $this->expectException('\InvalidArgumentException');
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WalletTest::getJson()
            ));

        $obj->get(WalletTest::getObject()->getName(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     */
    public function testGetMultipleParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $this->expectException('\InvalidArgumentException');
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . WalletTest::getJson() . ']'
            ));

        $walletNames = array(WalletTest::getObject()->getName());

        $obj->getMultiple($walletNames, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param WalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testDelete($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                true
            ));

        $result = $obj->delete(WalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}

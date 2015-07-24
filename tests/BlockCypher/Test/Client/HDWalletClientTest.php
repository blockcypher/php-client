<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\HDWalletClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\AddressListTest;
use BlockCypher\Test\Api\HDWalletGenerateAddressResponseTest;
use BlockCypher\Test\Api\HDWalletTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class HDWalletClientTest
 *
 * @package BlockCypher\Test\Client
 */
class HDWalletClientTest extends ClientTestCase
{
    /**
     * @return HDWalletClient
     */
    public static function getObject()
    {
        return new HDWalletClient();
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                HDWalletTest::getJson()
            ));

        $result = $obj->create(HDWalletTest::getObject(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGenerateAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                HDWalletGenerateAddressResponseTest::getJson()
            ));

        $result = $obj->generateAddress(HDWalletGenerateAddressResponseTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGet($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                HDWalletTest::getJson()
            ));

        $result = $obj->get(HDWalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultiple($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . HDWalletTest::getJson() . ']'
            ));

        $walletList = array(HDWalletTest::getObject()->getName());

        $result = $obj->getMultiple($walletList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], HDWalletTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
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

        $result = $obj->getWalletAddresses(HDWalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                HDWalletTest::getJson()
            ));

        $obj->get(HDWalletTest::getObject()->getName(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param HDWalletClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . HDWalletTest::getJson() . ']'
            ));

        $walletList = array(HDWalletTest::getObject()->getName());

        $obj->getMultiple($walletList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param HDWalletClient $obj
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

        $result = $obj->delete(HDWalletTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}
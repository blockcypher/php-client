<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\BlockClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\BlockTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class BlockClientTest
 *
 * @package BlockCypher\Test\Client
 */
class BlockClientTest extends ClientTestCase
{
    /**
     * @return BlockClient
     */
    public static function getObject()
    {
        return new BlockClient();
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithHash($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $result = $obj->get(BlockTest::getObject()->getHash(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithHashAndParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->get(BlockTest::getObject()->getHash(), $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithHeight($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $result = $obj->get(BlockTest::getObject()->getHeight(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithHeightAndParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->get(BlockTest::getObject()->getHeight(), $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param BlockClient $obj
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
                BlockTest::getJson()
            ));

        $obj->get(BlockTest::getObject()->getHeight(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultiple($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());

        $result = $obj->getMultiple($blockList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], BlockTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param BlockClient $obj
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
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());

        $obj->get($blockList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());
        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->getMultiple($blockList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], BlockTest::getObject());
    }
}
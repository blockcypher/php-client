<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\BlockchainClient;
use BlockCypher\Client\BlockClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\BlockchainTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class BlockchainClientTest
 *
 * @package BlockCypher\Test\Client
 */
class BlockchainClientTest extends ClientTestCase
{
    /**
     * @return BlockchainClient
     */
    public static function getObject()
    {
        return new BlockchainClient();
    }

    /**
     * @dataProvider mockProvider
     * @param BlockClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGet($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockchainTest::getJson()
            ));

        $result = $obj->get(BlockchainTest::getObject()->getName(), array(), $mockApiContext, $mockBlockCypherRestCall);
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
                BlockchainTest::getJson()
            ));

        $obj->get(BlockchainTest::getObject()->getName(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}
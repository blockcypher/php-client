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

    /**
     * Gets Json String of Feature Endpoint response
     * @return string
     */
    public static function featureResponse()
    {
        /*
        {
          "name": "bip65",
          "state": "EXCLUSIVE",
          "last_transition_height": 388380,
          "last_transition_hash": "000000000000000009f886db2c7c12a497603e86378bace3ead93d350be3f38c"
        }
        */

        return '{"name":"bip65","state":"EXCLUSIVE","last_transition_height":388380,"last_transition_hash":"000000000000000009f886db2c7c12a497603e86378bace3ead93d350be3f38c"}';
    }
    
    /**
     * @dataProvider mockProvider
     * @param BlockchainClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetFeature($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::featureResponse()
            ));

        $result = $obj->getFeature('bip65', array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertEquals(self::featureResponse(), $result);
    }
}
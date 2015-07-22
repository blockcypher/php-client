<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\NullDataClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\NullDataTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class NullDataClientTest
 *
 * @package BlockCypher\Test\Client
 */
class NullDataClientTest extends ClientTestCase
{
    /**
     * @return NullDataClient
     */
    public static function getObject()
    {
        return new NullDataClient();
    }

    /**
     * @dataProvider mockProvider
     * @param NullDataClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                NullDataTest::getJson()
            ));

        $result = $obj->create(NullDataTest::getObject(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param NullDataClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testEmbedString($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                NullDataTest::getJson()
            ));

        $result = $obj->embedString(NullDataTest::getObject()->getData(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param NullDataClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testEmbedHex($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                NullDataTest::getJsonWithHexData()
            ));

        $result = $obj->embedHex(NullDataTest::getObjectWithHexData()->getData(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}
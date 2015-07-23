<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\BlockClient;
use BlockCypher\Client\FaucetClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\FaucetResponseTest;
use BlockCypher\Test\Api\FaucetTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class FaucetClientTest
 *
 * @package BlockCypher\Test\Client
 */
class FaucetClientTest extends ClientTestCase
{
    /**
     * @return BlockClient
     */
    public static function getObject()
    {
        return new FaucetClient();
    }

    /**
     * @dataProvider mockProvider
     * @param FaucetClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testTurnOn($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FaucetResponseTest::getJson()
            ));

        $result = $obj->turnOn(FaucetTest::getObject(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\FaucetResponse', $result);
    }

    /**
     * @dataProvider mockProvider
     * @param FaucetClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testFundAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FaucetResponseTest::getJson()
            ));

        $faucetResponse = FaucetResponseTest::getObject();

        $result = $obj->fundAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd', 100000, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($faucetResponse, $result);
    }
}
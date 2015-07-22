<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\MicroTXClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\MicroTXTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class MicroTXClientTest
 *
 * @package BlockCypher\Test\Client
 */
class MicroTXClientTest extends ClientTestCase
{
    /**
     * @return MicroTXClient
     */
    public static function getObject()
    {
        return new MicroTXClient();
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                MicroTXTest::getJson()
            ));

        $result = $obj->create(
            MicroTXTest::getObject(),
            $mockApiContext,
            $mockBlockCypherRestCall
        );

        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\MicroTX', $result);
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testSend($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                MicroTXTest::getJson()
            ));

        $result = $obj->send(
            MicroTXTest::getObject(),
            $mockApiContext,
            $mockBlockCypherRestCall
        );

        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\MicroTX', $result);
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testFromPubkey($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                MicroTXTest::getJson()
            ));

        $result = $obj->sendSigned(
            "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff",
            "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
            10000,
            $mockApiContext,
            $mockBlockCypherRestCall
        );

        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testFromPrivate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                MicroTXTest::getJson()
            ));

        $result = $obj->sendWithPrivateKey(
            "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff",
            "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
            10000,
            $mockApiContext,
            $mockBlockCypherRestCall
        );

        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testFromWif($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                MicroTXTest::getJson()
            ));

        /** @noinspection SpellCheckingInspection */
        $result = $obj->sendWithWif(
            "BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ",
            "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
            10000,
            $mockApiContext,
            $mockBlockCypherRestCall
        );

        $this->assertNotNull($result);
    }
}
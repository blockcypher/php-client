<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Faucet;

/**
 * Class FaucetTest
 *
 * @package BlockCypher\Test\Api
 */
class FaucetTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Faucet
     */
    public static function getObject()
    {
        return new Faucet(self::getJson());
    }

    /**
     * Gets Json String of Object Address
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "address": "CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd",
            "amount": 100000,
            "error": "",
            "errors": []
        }
        */

        return '{"address":"CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd","amount":100000,"error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Faucet
     */
    public function testSerializationDeserialization()
    {
        $obj = new Faucet(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getAmount());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Faucet $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddress(), "CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd");
        $this->assertEquals($obj->getAmount(), 100000);
    }

    /**
     * @dataProvider mockProvider
     * @param Faucet $obj
     */
    public function testTurnOn($obj, /** @noinspection PhpDocSignatureInspection */
                               $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FaucetResponseTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->turnOn($mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\FaucetResponse', $result);
    }

    /**
     * @dataProvider mockProvider
     * @param Faucet $obj
     */
    public function testFundAddress($obj, /** @noinspection PhpDocSignatureInspection */
                                    $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FaucetResponseTest::getJson()
            ));

        $faucetResponse = FaucetResponseTest::getObject();

        /** @noinspection PhpParamsInspection */
        $result = $obj->fundAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd', 100000, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($faucetResponse, $result);
    }
}
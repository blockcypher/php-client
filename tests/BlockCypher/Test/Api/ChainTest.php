<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Chain;

/**
 * Class Chain
 *
 * @package BlockCypher\Test\Api
 */
class ChainTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Chain
     */
    public static function getObject()
    {
        return new Chain(self::getJson());
    }

    /**
     * Gets Json String of Object Chain
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "name": "BTC.main",
            "height": 351963,
            "hash": "0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21",
            "time": "2015-04-13T15:38:39.568144246Z",
            "latest_url": "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21",
            "previous_hash": "00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab",
            "previous_url": "https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab",
            "peer_count": 257,
            "unconfirmed_count": 3731
        }
        */

        return '{"name":"BTC.main","height":351963,"hash":"0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21","time":"2015-04-13T15:38:39.568144246Z","latest_url":"https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21","previous_hash":"00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab","previous_url":"https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab","peer_count":257,"unconfirmed_count":3731}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Chain
     */
    public function testSerializationDeserialization()
    {
        $obj = new Chain(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getHeight());
        $this->assertNotNull($obj->getHash());
        $this->assertNotNull($obj->getTime());
        $this->assertNotNull($obj->getLatestUrl());
        $this->assertNotNull($obj->getPreviousHash());
        $this->assertNotNull($obj->getPreviousUrl());
        $this->assertNotNull($obj->getPeerCount());
        $this->assertNotNull($obj->getUnconfirmedCount());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Chain $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getName(), "BTC.main");
        $this->assertEquals($obj->getHeight(), 351963);
        $this->assertEquals($obj->getHash(), "0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21");
        $this->assertEquals($obj->getTime(), "2015-04-13T15:38:39.568144246Z");
        $this->assertEquals($obj->getLatestUrl(), "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000004ffa5650fc8148beb6f9f21bd2a2db115376ecbcb61f21");
        $this->assertEquals($obj->getPreviousHash(), "00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab");
        $this->assertEquals($obj->getPreviousUrl(), "https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000df8d41fc91fb5514736270c6fd7930b4348c830a8648eab");
        $this->assertEquals($obj->getPeerCount(), 257);
        $this->assertEquals($obj->getUnconfirmedCount(), 3731);
    }

    /**
     * @dataProvider mockProvider
     * @param Chain $obj
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                ChainTest::getJson()
            ));

        $result = $obj->get("BTC.main", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Chain $obj
     * @param $mockApiContext
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForParams(
        $obj, /** @noinspection PhpDocSignatureInspection */
        $mockApiContext,
        $params
    )
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                ChainTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("BTC.main", $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}

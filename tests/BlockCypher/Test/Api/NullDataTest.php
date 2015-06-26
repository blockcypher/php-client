<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\NullData;

/**
 * Class NullDataTest
 *
 * @package BlockCypher\Test\Api
 */
class NullDataTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return NullData
     */
    public static function getObject()
    {
        return new NullData(self::getJson());
    }

    /**
     * Gets Json String of Object NullData
     * @return string
     */

    /**
     * Tests for Serialization and Deserialization Issues
     * @return NullData
     */
    public function testSerializationDeserialization()
    {
        $obj = new NullData(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getEncoding());
        $this->assertNotNull($obj->getData());
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getHash());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /** @noinspection SpellCheckingInspection */
    public static function getJson()
    {
        /*
        {
            "encoding": "string",
            "data": "***BlockCypher*Data*Endpoint*Test***",
            "token": "c0afcccdde5081d6429de37d16166ead",
            "hash": "ee87113bf23bea8f7cdb24bcfbfc55045aa405ad54fd20e94e61a34b4a17d165",
            "error": "",
            "errors": []
        }
        */

        /** @noinspection SpellCheckingInspection */
        return '{"encoding":"string","data":"***BlockCypher*Data*Endpoint*Test***","token":"c0afcccdde5081d6429de37d16166ead","hash":"ee87113bf23bea8f7cdb24bcfbfc55045aa405ad54fd20e94e61a34b4a17d165","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param NullData $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getEncoding(), "string");
        $this->assertEquals($obj->getData(), "***BlockCypher*Data*Endpoint*Test***");
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getHash(), "ee87113bf23bea8f7cdb24bcfbfc55045aa405ad54fd20e94e61a34b4a17d165");
    }

    /**
     * @dataProvider mockProvider
     * @param NullData $obj
     */
    public function testCreate($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson()
            ));

        $result = $obj->create(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}
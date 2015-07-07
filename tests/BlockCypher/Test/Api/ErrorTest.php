<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Error;

/**
 * Class ErrorTest
 *
 * @package BlockCypher\Test\Api
 */
class ErrorTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Error
     */
    public static function getObject()
    {
        return new Error(self::getJson());
    }

    /**
     * Gets Json String of Object Error
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "error": "message"
        }
        */
        return '{"error":"message"}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Error
     */
    public function testSerializationDeserialization()
    {
        $obj = new Error(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getError());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Error $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getError(), "message");
    }
}
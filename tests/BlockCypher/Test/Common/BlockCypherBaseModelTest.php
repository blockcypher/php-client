<?php

// Do not add namespace

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Test class for BlockCypherBaseModelTest.
 *
 */
class BlockCypherBaseModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return BlockCypherBaseModel
     */
    public static function getObject()
    {
        return new BlockCypherBaseModel(self::getJson());
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return BlockCypherBaseModel
     */
    public function testSerializationDeserialization()
    {
        $obj = new BlockCypherBaseModel(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getError());
        $this->assertNotNull($obj->getErrors());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object BlockCypherBaseModel
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "error": "TestError",
            "errors": [
                "TestError1",
                "TestError2"
            ]
        }
        */

        return '{"error":"TestError","errors":["TestError1","TestError2"]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getError(), "TestError");
        $this->assertEquals($obj->getErrors(), array("TestError1", "TestError2"));
    }
}

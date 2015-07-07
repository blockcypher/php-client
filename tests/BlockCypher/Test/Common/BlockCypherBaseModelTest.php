<?php

// Do not add namespace

use BlockCypher\Common\BlockCypherBaseModel;
use BlockCypher\Test\Api\ErrorTest;

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
     * Gets Json String of Object BlockCypherBaseModel
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "error":"message",
          "errors":[
            {
              "error":"message"
            }
          ]
        }
        */

        $error = ErrorTest::getJson();

        return '{"error":"message","errors":[' . $error . ']}';
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
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getError(), "message");
        $this->assertEquals($obj->getErrors(), array(ErrorTest::getObject()));
    }

    /**
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testGetErrorMessages($obj)
    {
        $this->assertEquals(count($obj->getErrors()), count($obj->getErrorMessages()));
        $this->assertContains("message", $obj->getErrorMessages());
    }

    /**
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testGetAllErrorMessages($obj)
    {
        $this->assertEquals(count($obj->getErrors()) + 1, count($obj->getAllErrorMessages()));
        $this->assertContains("message", $obj->getAllErrorMessages());
    }

    /**
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testAddError($obj)
    {
        $newError = new \BlockCypher\Api\Error();
        $newError->setError("new error");

        $obj->addError($newError);

        $this->assertContains("new error", $obj->getErrorMessages());
    }

    /**
     * @depends testSerializationDeserialization
     * @param BlockCypherBaseModel $obj
     */
    public function testRemoveError($obj)
    {
        $oldError = new \BlockCypher\Api\Error();
        $oldError->setError("message");

        $obj->removeError($oldError);

        $this->assertNotContains("message", $obj->getErrorMessages());
    }
}

<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\HyperSchema;

/**
 * Class HyperSchema
 *
 * @package BlockCypher\Test\Api
 */
class HyperSchemaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return HyperSchema
     */
    public static function getObject()
    {
        return new HyperSchema(self::getJson());
    }

    /**
     * Gets Json String of Object HyperSchema
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "fragmentResolution": "TestSample",
          "readonly": true,
          "contentEncoding": "TestSample",
          "pathStart": "TestSample",
          "mediaType": "TestSample"
        }
         */
        return '{"fragmentResolution":"TestSample","readonly":true,"contentEncoding":"TestSample","pathStart":"TestSample","mediaType":"TestSample"}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return HyperSchema
     */
    public function testSerializationDeserialization()
    {
        $obj = new HyperSchema(self::getJson());

        $this->assertNotNull($obj);
        // TODO: Circular Dependency.
        //$this->assertNotNull($obj->getLinks());
        $this->assertNotNull($obj->getFragmentResolution());
        $this->assertNotNull($obj->getReadonly());
        $this->assertNotNull($obj->getContentEncoding());
        $this->assertNotNull($obj->getPathStart());
        $this->assertNotNull($obj->getMediaType());
        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param HyperSchema $obj
     */
    public function testGetters($obj)
    {
        // TODO: Circular Dependency.
        //$this->assertEquals($obj->getLinks(), LinksTest::getObject());
        $this->assertEquals($obj->getFragmentResolution(), "TestSample");
        $this->assertEquals($obj->getReadonly(), true);
        $this->assertEquals($obj->getContentEncoding(), "TestSample");
        $this->assertEquals($obj->getPathStart(), "TestSample");
        $this->assertEquals($obj->getMediaType(), "TestSample");
    }

}

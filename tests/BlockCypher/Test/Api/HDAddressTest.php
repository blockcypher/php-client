<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\HDAddress;

/**
 * Class HDAddressTest
 *
 * @package BlockCypher\Test\Api
 */
class HDAddressTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return HDAddress
     */
    public static function getObject()
    {
        return new HDAddress(self::getJson());
    }

    /**
     * Gets Json String of Object HDAddress
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "address": "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh",
            "public": "029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0",
            "path": "m/1/0"
        }
        */
        return '{"address":"1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh","public":"029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0","path":"m/1/0"}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return HDAddress
     */
    public function testSerializationDeserialization()
    {
        $obj = new HDAddress(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getPath());
        $this->assertNotNull($obj->getPublic());

        $this->assertEquals(self::getJson(), $obj->toJSON());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDAddress $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddress(), '1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh');
        $this->assertEquals($obj->getPublic(), '029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0');
        $this->assertEquals($obj->getPath(), 'm/1/0');
    }
}
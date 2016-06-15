<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\HDChain;

/**
 * Class HDChainTest
 *
 * @package BlockCypher\Test\Api
 */
class HDChainTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return HDChain
     */
    public static function getObject()
    {
        return new HDChain(self::getJson());
    }

    /**
     * Gets Json String of Object HDChain
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "index": 1,
            "chain_addresses": [
                {
                    "address": "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh",
                    "path": "m/1/0"
                }
            ]
        }
        */

        $hdAddress = HDAddressTest::getJson();
        
        return '{"index":1,"chain_addresses":[' . $hdAddress . ']}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return HDChain
     */
    public function testSerializationDeserialization()
    {
        $obj = new HDChain(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getChainAddresses());
        $this->assertNotNull($obj->getIndex());

        $this->assertEquals(self::getJson(), $obj->toJSON());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDChain $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getChainAddresses(), array(HDAddressTest::getObject()));
        $this->assertEquals($obj->getIndex(), 1);
    }
}
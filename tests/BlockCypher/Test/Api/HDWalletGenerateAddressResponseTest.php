<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\HDWalletGenerateAddressResponse;

/**
 * Class HDWalletGenerateAddressResponseTest
 *
 * @package BlockCypher\Test\Api
 */
class HDWalletGenerateAddressResponseTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return HDWalletGenerateAddressResponse
     */
    public static function getObject()
    {
        return new HDWalletGenerateAddressResponse(self::getJson());
    }

    /**
     * Gets Json String of Object WalletGenerateAddressResponse
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "token": "c0afcccdde5081d6429de37d16166ead",
            "name": "bob",
            "addresses": [
                "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"
            ],
            "hd": true,
            "subchain_index": 1,
            "address": "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh",
            "public": "029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0",
            "error": "",
            "errors": []
        }
        */

        return '{"token":"c0afcccdde5081d6429de37d16166ead","name":"bob","addresses":["1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"],"hd":true,"subchain_index":1,"address":"1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh","public":"029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return HDWalletGenerateAddressResponse
     */
    public function testSerializationDeserialization()
    {
        $obj = new HDWalletGenerateAddressResponse(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getHd());
        $this->assertNotNull($obj->getSubchainIndex());
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getPublic());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param HDWalletGenerateAddressResponse $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getName(), "bob");
        $this->assertEquals($obj->getAddresses(), array(
            "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"
        ));
        $this->assertEquals($obj->getHd(), true);
        $this->assertEquals($obj->getSubchainIndex(), 1);
        $this->assertEquals($obj->getAddress(), "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh");
        $this->assertEquals($obj->getPublic(), "029b393153a1ec68c7af3a98e88aecede3a409f27e698c090540098611c79e05b0");
    }
}
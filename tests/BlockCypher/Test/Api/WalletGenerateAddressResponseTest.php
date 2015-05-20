<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\WalletGenerateAddressResponse;

/**
 * Class WalletGenerateAddressResponseTest
 *
 * @package BlockCypher\Test\Api
 */
class WalletGenerateAddressResponseTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return WalletGenerateAddressResponse
     */
    public static function getObject()
    {
        return new WalletGenerateAddressResponse(self::getJson());
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
          "name": "alice",
          "addresses": [
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
          ],
          "private": "b86b2843a605a4fc7519b7f2ab4e974bf91084759357226c1cbc22892e783b25",
          "public": "03ce35d82764436764f4eb6ed625e4d36de7897f22373b1ef8959deebf392f10cf",
          "address": "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
          "wif": "L3QCMJkNZARVUAfNKFFMpBUWm8JzkzuQTVYbMpwLYhp44pKuJqGf",
          "error": "",
          "errors": []
        }
        */

        return '{"token":"c0afcccdde5081d6429de37d16166ead","name":"alice","addresses":["13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j","1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"private":"b86b2843a605a4fc7519b7f2ab4e974bf91084759357226c1cbc22892e783b25","public":"03ce35d82764436764f4eb6ed625e4d36de7897f22373b1ef8959deebf392f10cf","address":"18VAyux27CiWQnmYumZeTKNcaw6opvKRLq","wif":"L3QCMJkNZARVUAfNKFFMpBUWm8JzkzuQTVYbMpwLYhp44pKuJqGf","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return WalletGenerateAddressResponse
     */
    public function testSerializationDeserialization()
    {
        $obj = new WalletGenerateAddressResponse(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getPrivate());
        $this->assertNotNull($obj->getPublic());
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getWif());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param WalletGenerateAddressResponse $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getName(), "alice");
        $this->assertEquals($obj->getAddresses(), array(
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
        ));
        $this->assertEquals($obj->getPrivate(), "b86b2843a605a4fc7519b7f2ab4e974bf91084759357226c1cbc22892e783b25");
        $this->assertEquals($obj->getPublic(), "03ce35d82764436764f4eb6ed625e4d36de7897f22373b1ef8959deebf392f10cf");
        $this->assertEquals($obj->getAddress(), "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq");
        $this->assertEquals($obj->getWif(), "L3QCMJkNZARVUAfNKFFMpBUWm8JzkzuQTVYbMpwLYhp44pKuJqGf");
    }
}
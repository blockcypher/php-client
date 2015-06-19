<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\AddressList;

/**
 * Class AddressListTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressListTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return AddressList
     */
    public static function getObject()
    {
        return new AddressList(self::getJson());
    }

    /**
     * Gets Json String of Object AddressList
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "addresses": ["13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"]
        }
        */
        return '{"addresses":["13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return AddressList
     */
    public function testSerializationDeserialization()
    {
        $obj = new AddressList(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddresses());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressList $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddresses(), array("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"));
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressList $obj
     */
    public function testAddAddress($obj)
    {
        $obj->addAddress("1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e");
        $this->assertContains("1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e", $obj->getAddresses());
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressList $obj
     */
    public function testRemoveAddress($obj)
    {
        $obj->removeAddress("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j");
        $this->assertNotContains("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j", $obj->getAddresses());
    }

    public function testFromAddressesArray()
    {
        $addressList = \BlockCypher\Api\AddressList::fromAddressesArray(array(
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
        ));

        $this->assertEquals(array("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"), $addressList->getAddresses());
    }
}
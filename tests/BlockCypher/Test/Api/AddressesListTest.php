<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\AddressesList;

/**
 * Class AddressesListTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressesListTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return AddressesList
     */
    public static function getObject()
    {
        return new AddressesList(self::getJson());
    }

    /**
     * Gets Json String of Object AddressesList
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
     * @return AddressesList
     */
    public function testSerializationDeserialization()
    {
        $obj = new AddressesList(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddresses());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressesList $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddresses(), array("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"));
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressesList $obj
     */
    public function testAddAddress($obj)
    {
        $obj->addAddress("1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e");
        $this->assertContains("1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e", $obj->getAddresses());
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressesList $obj
     */
    public function testRemoveAddress($obj)
    {
        $obj->removeAddress("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j");
        $this->assertNotContains("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j", $obj->getAddresses());
    }

    public function testFromAddressesArray()
    {
        $addressesList = \BlockCypher\Api\AddressesList::fromAddressesArray(array(
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
        ));

        $this->assertEquals(array("13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"), $addressesList->getAddresses());
    }
}
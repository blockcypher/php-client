<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\WalletInfo;

/**
 * Class WalletInfoTest
 *
 * @package BlockCypher\Test\Api
 */
class WalletInfoTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return WalletInfo
     */
    public static function getObject()
    {
        return new WalletInfo(self::getJson());
    }

    /**
     * Gets Json String of Object Wallet
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "token": "c0afcccdde5081d6429de37d16166ead",
            "name": "bob",
            "addresses": [
                "18FcseQ86zCaXzLbgDsH86292xb2EuKtFW",
                "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"
            ],
            "hd": true
        }
        */

        return '{"token":"c0afcccdde5081d6429de37d16166ead","name":"bob","addresses":["18FcseQ86zCaXzLbgDsH86292xb2EuKtFW","1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"],"hd":true}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return WalletInfo
     */
    public function testSerializationDeserialization()
    {
        $obj = new WalletInfo(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getHd());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param WalletInfo $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getName(), "bob");
        $this->assertEquals($obj->getAddresses(), array("18FcseQ86zCaXzLbgDsH86292xb2EuKtFW", "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"));
        $this->assertEquals($obj->getHd(), true);
    }

    /**
     * @depends testSerializationDeserialization
     * @param WalletInfo $obj
     */
    public function testAddAddress($obj)
    {
        $obj->addAddress("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn");

        $this->assertContains("1jr1rHMthQVMNSYswB9ExSvYn339fWMzn", $obj->getAddresses());
    }

    /**
     * @depends testSerializationDeserialization
     * @param WalletInfo $obj
     */
    public function testRemoveAddress($obj)
    {
        $addresses = self::addresses();
        $address = $addresses[0];
        $obj->removeAddress($address);

        $this->assertNotContains($address, $obj->getAddresses());
    }

    /**
     * @return string[]
     */
    public static function addresses()
    {
        $addresses = array(
            "18FcseQ86zCaXzLbgDsH86292xb2EuKtFW",
            "1NwEtFZ6Td7cpKaJtYoeryS6avP2TUkSMh"
        );
        return $addresses;
    }
}

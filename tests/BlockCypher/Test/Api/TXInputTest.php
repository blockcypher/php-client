<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\TXInput;

/**
 * Class TXInputTest
 *
 * @package BlockCypher\Test\Api
 */
class TXInputTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return TXInput
     */
    public static function getObject()
    {
        return new TXInput(self::getJson());
    }

    /**
     * Gets Json String of Object TXInput
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "prev_hash": "c719e0c52f63d9afbb72b00324499c0510672fa63c205db982188161ee3f105c",
            "output_index": 0,
            "script": "4830450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b01210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf",
            "output_value": 50000,
            "sequence": 4294967295,
            "addresses": [
              "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
            ],
            "script_type": "pay-to-pubkey-hash",
            "age": 5197,
            "wallet_name": "alice",
            "wallet_token": "c0afcccdde5081d6429de37d16166ead",
            "error": "message",
            "errors": []
        }
        */
        return '{"prev_hash":"c719e0c52f63d9afbb72b00324499c0510672fa63c205db982188161ee3f105c","output_index":0,"script":"4830450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b01210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf","output_value":50000,"sequence":4294967295,"addresses":["n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"],"script_type":"pay-to-pubkey-hash","age":5197,"wallet_name":"alice","wallet_token":"c0afcccdde5081d6429de37d16166ead","error":"message","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return TXInput
     */
    public function testSerializationDeserialization()
    {
        $obj = new TXInput(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getPrevHash());
        $this->assertNotNull($obj->getOutputIndex());
        $this->assertNotNull($obj->getScript());
        $this->assertNotNull($obj->getOutputValue());
        $this->assertNotNull($obj->getAge()); // Only present for unconfirmed transactions
        $this->assertNotNull($obj->getSequence());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getScriptType());

        // Only present in request body when wallet is used instead of an address.
        // See http://dev.blockcypher.com/#creating-transactions
        $this->assertNotNull($obj->getWalletName());
        $this->assertNotNull($obj->getWalletToken());

        $this->assertNotNull($obj->getError());
        $this->assertNotNull($obj->getErrors());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param TXInput $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getPrevHash(), "c719e0c52f63d9afbb72b00324499c0510672fa63c205db982188161ee3f105c");
        $this->assertEquals($obj->getOutputIndex(), 0);
        $this->assertEquals($obj->getScript(), "4830450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b01210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf");
        $this->assertEquals($obj->getOutputValue(), 50000);
        $this->assertEquals($obj->getAge(), 5197);
        $this->assertEquals($obj->getSequence(), 4294967295);
        $this->assertEquals($obj->getAddresses(), array("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"));
        $this->assertEquals($obj->getScriptType(), "pay-to-pubkey-hash");

        // Only present in request body when wallet is used instead of an address.
        // See http://dev.blockcypher.com/#creating-transactions
        $this->assertEquals($obj->getWalletName(), "alice");
        $this->assertEquals($obj->getWalletToken(), "c0afcccdde5081d6429de37d16166ead");

        $this->assertEquals($obj->getError(), "message");
        $this->assertEquals($obj->getErrors(), array());
    }
}
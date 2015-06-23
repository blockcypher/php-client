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
    // TODO:
    // - add test for unconfirmed transaction with age property

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
            "error": "",
            "errors": []
        }
        */
        return '{"prev_hash":"c719e0c52f63d9afbb72b00324499c0510672fa63c205db982188161ee3f105c","output_index":0,"script":"4830450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b01210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf","output_value":50000,"sequence":4294967295,"addresses":["n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"],"script_type":"pay-to-pubkey-hash","error":"","errors":[]}';
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
        // TODO: only present for unconfirmed transactions
        //$this->assertNotNull($obj->getAge());
        $this->assertNotNull($obj->getSequence());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getScriptType());

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
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getScript(), "4830450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b01210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf");
        $this->assertEquals($obj->getOutputValue(), 50000);
        // TODO: only present for unconfirmed transactions
        //$this->assertEquals($obj->getAge(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getSequence(), 4294967295);
        $this->assertEquals($obj->getAddresses(), array("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"));
        $this->assertEquals($obj->getScriptType(), "pay-to-pubkey-hash");
    }
}
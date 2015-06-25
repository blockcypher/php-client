<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\TXOutput;

/**
 * Class TXOutputTest
 *
 * @package BlockCypher\Test\Api
 */
class TXOutputTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return TXOutput
     */
    public static function getObject()
    {
        return new TXOutput(self::getJson());
    }

    /**
     * Gets Json String of Object TXOutput
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "value": 70320221545,
            "script": "76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac",
            "spent_by": "35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee",
            "address": "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV",
            "addresses": [
              "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"
            ],
            "script_type": "pay-to-pubkey-hash",
            "error": "",
            "errors": []
        }
        */
        /** @noinspection SpellCheckingInspection */
        return '{"value":70320221545,"script":"76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac","spent_by":"35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee","address":"1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV","addresses":["1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"],"script_type":"pay-to-pubkey-hash","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return TXOutput
     */
    public function testSerializationDeserialization()
    {
        $obj = new TXOutput(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getValue());
        $this->assertNotNull($obj->getScript());
        $this->assertNotNull($obj->getSpentBy());
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getScriptType());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param TXOutput $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getValue(), 70320221545);
        $this->assertEquals($obj->getScript(), "76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac");
        $this->assertEquals($obj->getSpentBy(), "35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee");
        $this->assertEquals($obj->getAddress(), "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV");
        $this->assertEquals($obj->getAddresses(), array("1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"));
        $this->assertEquals($obj->getScriptType(), "pay-to-pubkey-hash");
    }
}
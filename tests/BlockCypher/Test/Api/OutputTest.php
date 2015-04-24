<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Output;

/**
 * Class OutputTest
 *
 * @package BlockCypher\Test\Api
 */
class OutputTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Output
     */
    public static function getObject()
    {
        return new Output(self::getJson());
    }

    /**
     * Gets Json String of Object InvoiceItem
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "value": 70320221545,
          "script": "76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac",
          "spent_by": "35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee",
          "addresses": [
            "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"
          ],
          "script_type": "pay-to-pubkey-hash"
        }
        */
        /** @noinspection SpellCheckingInspection */
        return '{"value":70320221545,"script":"76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac","spent_by":"35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee","addresses":["1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"],"script_type":"pay-to-pubkey-hash"}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Output
     */
    public function testSerializationDeserialization()
    {
        $obj = new Output(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getValue());
        $this->assertNotNull($obj->getScript());
        $this->assertNotNull($obj->getSpentBy());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getScriptType());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Output $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getValue(), 70320221545);
        $this->assertEquals($obj->getScript(), "76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac");
        $this->assertEquals($obj->getSpentBy(), "35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee");
        $this->assertEquals($obj->getAddresses(), array("1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"));
        $this->assertEquals($obj->getScriptType(), "pay-to-pubkey-hash");
    }
}
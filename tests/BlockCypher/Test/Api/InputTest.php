<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Input;

/**
 * Class InputTest
 *
 * @package BlockCypher\Test\Api
 */
class InputTest extends ResourceModelTestCase
{
    // TODO:
    // - add test for unconfirmed transaction with age property

    /**
     * Gets Object Instance with Json data filled in
     * @return Input
     */
    public static function getObject()
    {
        return new Input(self::getJson());
    }

    /**
     * Gets Json String of Object InvoiceItem
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "prev_hash": "583910b7bf90ab802e22e5c25a89b59862b20c8c1aeb24dfb94e7a508a70f121",
          "output_index": 1,
          "script": "4830450220504b1ccfddf508422bdd8b0fcda2b1483e87aee1b486c0130bc29226bbce3b4e022100b5befcfcf0d3bf6ebf0ac2f93badb19e3042c7bed456c398e743b885e782466c012103b1feb40b99e8ff18469484a50e8b52cc478d5f4f773a341fbd920a4ceaedd4bf",
          "output_value": 16450000,
          "sequence": 4294967295,
          "addresses": [
            "1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq"
          ],
          "script_type": "pay-to-pubkey-hash"
        }
        */
        return '{"prev_hash":"583910b7bf90ab802e22e5c25a89b59862b20c8c1aeb24dfb94e7a508a70f121","output_index":1,"script":"4830450220504b1ccfddf508422bdd8b0fcda2b1483e87aee1b486c0130bc29226bbce3b4e022100b5befcfcf0d3bf6ebf0ac2f93badb19e3042c7bed456c398e743b885e782466c012103b1feb40b99e8ff18469484a50e8b52cc478d5f4f773a341fbd920a4ceaedd4bf","output_value":16450000,"sequence":4294967295,"addresses":["1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq"],"script_type":"pay-to-pubkey-hash"}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Input
     */
    public function testSerializationDeserialization()
    {
        $obj = new Input(self::getJson());

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
     * @param Input $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getPrevHash(), "583910b7bf90ab802e22e5c25a89b59862b20c8c1aeb24dfb94e7a508a70f121");
        $this->assertEquals($obj->getOutputIndex(), 1);
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getScript(), "4830450220504b1ccfddf508422bdd8b0fcda2b1483e87aee1b486c0130bc29226bbce3b4e022100b5befcfcf0d3bf6ebf0ac2f93badb19e3042c7bed456c398e743b885e782466c012103b1feb40b99e8ff18469484a50e8b52cc478d5f4f773a341fbd920a4ceaedd4bf");
        $this->assertEquals($obj->getOutputValue(), 16450000);
        // TODO: only present for unconfirmed transactions
        //$this->assertEquals($obj->getAge(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getSequence(), 4294967295);
        $this->assertEquals($obj->getAddresses(), array("1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq"));
        $this->assertEquals($obj->getScriptType(), "pay-to-pubkey-hash");
    }
}
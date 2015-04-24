<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Txref;

/**
 * Class TxrefTest
 *
 * @package BlockCypher\Test\Api
 */
class TxrefTest extends ResourceModelTestCase
{
    // TODO:
    // - add test for double spend case (double_of, receive_count)
    // - add test for confidence

    /**
     * Gets Object Instance with Json data filled in
     * @return Txref
     */
    public static function getObject()
    {
        return new Txref(self::getJson());
    }

    /**
     * Gets Json String of Object InvoiceItem
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "tx_hash": "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e",
            "block_height": 302013,
            "tx_input_n": -1,
            "tx_output_n": 0,
            "value": 20213,
            "spent": false,
            "confirmations": 50118,
            "confirmed": "2014-05-22T03:46:25Z",
            "double_spend": false
        }
        */
        return '{"tx_hash":"14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e","block_height":302013,"tx_input_n":-1,"tx_output_n":0,"value":20213,"spent":false,"confirmations":50118,"confirmed":"2014-05-22T03:46:25Z","double_spend":false}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Txref
     */
    public function testSerializationDeserialization()
    {
        $obj = new Txref(self::getJson());
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getTxHash());
        $this->assertNotNull($obj->getBlockHeight());
        $this->assertNotNull($obj->getTxInputN());
        $this->assertNotNull($obj->gettxOutputN());
        $this->assertNotNull($obj->getValue());
        $this->assertNotNull($obj->isSpent());
        $this->assertNotNull($obj->getConfirmations());
        $this->assertNotNull($obj->getConfirmed());
        $this->assertNotNull($obj->isDoubleSpend());
        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Txref $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getTxHash(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getBlockHeight(), 302013);
        $this->assertEquals($obj->getTxInputN(), -1);
        $this->assertEquals($obj->gettxOutputN(), 0);
        $this->assertEquals($obj->getValue(), 20213);
        $this->assertEquals($obj->isSpent(), false);
        $this->assertEquals($obj->getConfirmations(), 50118);
        $this->assertEquals($obj->getConfirmed(), "2014-05-22T03:46:25Z");
        $this->assertEquals($obj->isDoubleSpend(), false);
    }
}
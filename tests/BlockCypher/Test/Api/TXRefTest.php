<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\TXRef;

/**
 * Class TXRefTest
 *
 * @package BlockCypher\Test\Api
 */
class TXRefTest extends ResourceModelTestCase
{
    // TODO: add tests
    // - add test for double spend case (double_of, receive_count)
    // - add test for confidence

    /**
     * Gets Object Instance with Json data filled in
     * @return TXRef
     */
    public static function getObject()
    {
        return new TXRef(self::getJson());
    }

    /**
     * Gets Json String of Object TXRef
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
            "ref_balance": 35000,
            "preference": "high",
            "spent": false,
            "spent_by": "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e",
            "confirmations": 50118,
            "confirmed": "2014-05-22T03:46:25Z",
            "received": "2014-05-22T03:46:25Z",
            "double_spend": false,
            "double_of": "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e",
            "receive_count": 42,
            "confidence": 0.98819,
            "error": "",
            "errors": []
        }
        */
        return '{"tx_hash":"14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e","block_height":302013,"tx_input_n":-1,"tx_output_n":0,"value":20213,"ref_balance":35000,"preference":"high","spent":false,"spent_by":"14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e","confirmations":50118,"confirmed":"2014-05-22T03:46:25Z","received":"2014-05-22T03:46:25Z","double_spend":false,"double_of":"14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e","receive_count":42,"confidence":0.98819,"error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return TXRef
     */
    public function testSerializationDeserialization()
    {
        $obj = new TXRef(self::getJson());
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getTxHash());
        $this->assertNotNull($obj->getBlockHeight());
        $this->assertNotNull($obj->getTxInputN());
        $this->assertNotNull($obj->gettxOutputN());
        $this->assertNotNull($obj->getValue());
        $this->assertNotNull($obj->getRefBalance());
        $this->assertNotNull($obj->getPreference());
        $this->assertNotNull($obj->isSpent());
        $this->assertNotNull($obj->getSpent());
        $this->assertNotNull($obj->getSpentBy());
        $this->assertNotNull($obj->getConfirmations());
        $this->assertNotNull($obj->getConfirmed());
        $this->assertNotNull($obj->getReceived());
        $this->assertNotNull($obj->isDoubleSpend());
        $this->assertNotNull($obj->getDoubleOf());
        $this->assertNotNull($obj->getReceiveCount());
        $this->assertNotNull($obj->getConfidence());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param TXRef $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getTxHash(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getBlockHeight(), 302013);
        $this->assertEquals($obj->getTxInputN(), -1);
        $this->assertEquals($obj->gettxOutputN(), 0);
        $this->assertEquals($obj->getValue(), 20213);
        $this->assertEquals($obj->getRefBalance(), 35000);
        $this->assertEquals($obj->getPreference(), "high");
        $this->assertEquals($obj->isSpent(), false);
        $this->assertEquals($obj->getSpent(), false);
        $this->assertEquals($obj->getSpentBy(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getConfirmations(), 50118);
        $this->assertEquals($obj->getConfirmed(), "2014-05-22T03:46:25Z");
        $this->assertEquals($obj->getReceived(), "2014-05-22T03:46:25Z");
        $this->assertEquals($obj->isDoubleSpend(), false);
        $this->assertEquals($obj->getDoubleSpend(), false);
        $this->assertEquals($obj->getDoubleOf(), "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e");
        $this->assertEquals($obj->getReceiveCount(), 42);
        $this->assertEquals($obj->getConfidence(), 0.98819);
    }
}

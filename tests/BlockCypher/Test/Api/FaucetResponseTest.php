<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\FaucetResponse;

/**
 * Class FaucetResponse
 *
 * @package BlockCypher\Test\Api
 */
class FaucetResponseTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return FaucetResponse
     */
    public static function getObject()
    {
        return new FaucetResponse(self::getJson());
    }

    /**
     * Gets Json String of Object FaucetResponse
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "address": "CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd",
            "amount": 100000,
            "tx_ref": "a0704e43c11b9b124d7604870aae186b4d9b9232f428582305726fc10a372a6c",
            "error": "",
            "errors": []
        }
        */

        return '{"address":"CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd","amount":100000,"tx_ref":"a0704e43c11b9b124d7604870aae186b4d9b9232f428582305726fc10a372a6c","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return FaucetResponse
     */
    public function testSerializationDeserialization()
    {
        $obj = new FaucetResponse(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getAmount());
        $this->assertNotNull($obj->getTxRef());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param FaucetResponse $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddress(), "CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd");
        $this->assertEquals($obj->getAmount(), 100000);
        $this->assertEquals($obj->getTxRef(), "a0704e43c11b9b124d7604870aae186b4d9b9232f428582305726fc10a372a6c");
    }
}
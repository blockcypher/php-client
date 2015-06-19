<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\PaymentForwardCallback;

/**
 * Class PaymentForwardCallbackTest
 *
 * @package BlockCypher\Test\Api
 */
class PaymentForwardCallbackTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return PaymentForwardCallback
     */
    public static function getObject()
    {
        return new PaymentForwardCallback(self::getJson());
    }

    /**
     * Gets Json String of Object PaymentForwardCallback
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "value":100000000,
          "input_address":"16uKw7GsQSzfMaVTcT7tpFQkd7Rh9qcXWX",
          "destination":"15qx9ug952GWGTNn7Uiv6vode4RcGrRemh",
          "input_transaction_hash":"f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449",
          "transaction_hash":"6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4",
          "error": "",
          "errors": []
        }
        */
        return '{"value":100000000,"input_address":"16uKw7GsQSzfMaVTcT7tpFQkd7Rh9qcXWX","destination":"15qx9ug952GWGTNn7Uiv6vode4RcGrRemh","input_transaction_hash":"f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449","transaction_hash":"6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return PaymentForwardCallback
     */
    public function testSerializationDeserialization()
    {
        $obj = new PaymentForwardCallback(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getValue());
        $this->assertNotNull($obj->getInputAddress());
        $this->assertNotNull($obj->getDestination());
        $this->assertNotNull($obj->getInputTransactionHash());
        $this->assertNotNull($obj->getTransactionHash());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param PaymentForwardCallback $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getValue(), 100000000);
        $this->assertEquals($obj->getInputAddress(), "16uKw7GsQSzfMaVTcT7tpFQkd7Rh9qcXWX");
        $this->assertEquals($obj->getDestination(), "15qx9ug952GWGTNn7Uiv6vode4RcGrRemh");
        $this->assertEquals($obj->getInputTransactionHash(), "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449");
        $this->assertEquals($obj->getTransactionHash(), "6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4");
    }
}

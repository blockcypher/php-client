<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\PaymentForward;

/**
 * Class PaymentForwardTest
 *
 * @package BlockCypher\Test\Api
 */
class PaymentForwardTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return PaymentForward
     */
    public function testSerializationDeserialization()
    {
        $obj = new PaymentForward(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getId());
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getDestination());
        $this->assertNotNull($obj->getInputAddress());
        $this->assertNotNull($obj->getProcessFeesAddress());
        $this->assertNotNull($obj->getProcessFeesSatoshis());
        $this->assertNotNull($obj->getProcessFeesPercent());
        $this->assertNotNull($obj->getCallbackUrl());
        $this->assertNotNull($obj->getEnableConfirmations());
        $this->assertNotNull($obj->getMiningFeesSatoshis());
        $this->assertNotNull($obj->getTransactions());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object PaymentForward
     * @return string
     */
    public static function getJson()
    {
        /* Sample full object not real case. Some attributes are optional or exclusive
        {
            "destination": "15qx9ug952GWGTNn7Uiv6vode4RcGrRemh",
            "callback_url": "http://requestb.in/rwp6jirw?uniqid=5582e3872f8b3",
            "id": "6908058c-b80d-466b-a4de-954ff2fad971",
            "token": "c0afcccdde5081d6429de37d16166ead",
            "input_address": "1E4FVAQAsWTWbzu4UWxmjpaq3v26QNZhy4",
            "process_fees_address": "1LWw6FdzNUcX8bnekMMZ7eofcGF7SXmbrL",
            "process_fees_satoshis": 10000,
            "process_fees_percent": 0.1,
            "enable_confirmations": true,
            "mining_fees_satoshis": 10000,
            "transactions": [
                "6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4"
            ],
            "error": "",
            "errors": []
        }
        */
        return '{"destination":"15qx9ug952GWGTNn7Uiv6vode4RcGrRemh","callback_url":"http://requestb.in/rwp6jirw?uniqid=5582e3872f8b3","id":"6908058c-b80d-466b-a4de-954ff2fad971","token":"c0afcccdde5081d6429de37d16166ead","input_address":"1E4FVAQAsWTWbzu4UWxmjpaq3v26QNZhy4","process_fees_address":"1LWw6FdzNUcX8bnekMMZ7eofcGF7SXmbrL","process_fees_satoshis":10000,"process_fees_percent":0.1,"enable_confirmations":true,"mining_fees_satoshis":10000,"transactions":["6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4"],"error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param PaymentForward $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getId(), "6908058c-b80d-466b-a4de-954ff2fad971");
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getDestination(), "15qx9ug952GWGTNn7Uiv6vode4RcGrRemh");
        $this->assertEquals($obj->getInputAddress(), "1E4FVAQAsWTWbzu4UWxmjpaq3v26QNZhy4");
        $this->assertEquals($obj->getProcessFeesAddress(), "1LWw6FdzNUcX8bnekMMZ7eofcGF7SXmbrL");
        $this->assertEquals($obj->getProcessFeesSatoshis(), 10000);
        $this->assertEquals($obj->getProcessFeesPercent(), 0.1);
        $this->assertEquals($obj->getCallbackUrl(), "http://requestb.in/rwp6jirw?uniqid=5582e3872f8b3");
        $this->assertEquals($obj->getEnableConfirmations(), true);
        $this->assertEquals($obj->getMiningFeesSatoshis(), 10000);
        $this->assertEquals($obj->getTransactions(), array("6336b42b5b80118d3b15c8fc0cf7fda2414bec4d90cbbbf6148ed58089ee1ad4"));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage callback_url is not a fully qualified URL
     */
    public function testCallbackUrlValidationForUrl()
    {
        $obj = new PaymentForward();
        $obj->setCallbackUrl(null);
    }

    /**
     * @dataProvider mockProvider
     * @param PaymentForward $obj
     */
    public function testCreate($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson()
            ));

        $result = $obj->create($mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param PaymentForward $obj
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                PaymentForwardTest::getJson()
            ));

        $result = $obj->get("paymentForwardId", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param PaymentForward $obj
     * @param $mockApiContext
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForParams(
        $obj, /** @noinspection PhpDocSignatureInspection */
        $mockApiContext,
        $params
    )
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                PaymentForwardTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("paymentForwardId", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param PaymentForward $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . PaymentForwardTest::getJson() . ']'
            ));

        $paymentForwardList = array(PaymentForwardTest::getObject()->getId());

        $result = $obj->getMultiple($paymentForwardList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], PaymentForwardTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return PaymentForward
     */
    public static function getObject()
    {
        return new PaymentForward(self::getJson());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param PaymentForward $obj
     * @param $mockApiContext
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleParamsValidationForParams(
        $obj, /** @noinspection PhpDocSignatureInspection */
        $mockApiContext,
        $params
    )
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . PaymentForwardTest::getJson() . ']'
            ));

        $paymentForwardList = array(PaymentForwardTest::getObject()->getId());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($paymentForwardList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param PaymentForward $obj
     */
    public function testGetAll($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . PaymentForwardTest::getJson() . ']'
            ));

        $result = $obj->getAll(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], PaymentForwardTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param PaymentForward $obj
     */
    public function testDelete($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                true
            ));

        $result = $obj->delete($mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }
}

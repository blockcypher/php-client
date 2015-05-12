<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\TransactionConfidence;

/**
 * Class TransactionConfidenceTest
 *
 * @package BlockCypher\Test\Api
 */
class TransactionConfidenceTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return TransactionConfidence
     */
    public function testSerializationDeserialization()
    {
        $obj = new TransactionConfidence(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAgeMillis());
        $this->assertNotNull($obj->getReceiveCount());
        $this->assertNotNull($obj->getConfidence());
        $this->assertNotNull($obj->getTxhash());
        $this->assertNotNull($obj->getTxurl());
        $this->assertNotNull($obj->getError());
        $this->assertNotNull($obj->getErrors());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object TransactionConfidence
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "age_millis": 1082096894333054400,
            "receive_count": -1,
            "confidence": 1,
            "txhash": "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449",
            "txurl": "https://api.blockcypher.com/v1/btc/main/txs/f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449",
            "error": "",
            "errors": []
        }
        */
        return '{"age_millis":1082096894333054400,"receive_count":-1,"confidence":1,"txhash":"f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449","txurl":"https://api.blockcypher.com/v1/btc/main/txs/f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param TransactionConfidence $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAgeMillis(), 1082096894333054400);
        $this->assertEquals($obj->getReceiveCount(), -1);
        $this->assertEquals($obj->getConfidence(), 1);
        $this->assertEquals($obj->getTxhash(), "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449");
        $this->assertEquals($obj->getTxurl(), "https://api.blockcypher.com/v1/btc/main/txs/f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449");
        $this->assertEquals($obj->getError(), "");
        $this->assertEquals($obj->getErrors(), array());
    }

    /**
     * @dataProvider mockProvider
     * @param TransactionConfidence $obj
     */
    public function testGet($obj, /** @noinspection PhpDocSignatureInspection */
                            $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\\BlockCypher\\Transport\\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TransactionConfidenceTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TransactionConfidence $obj
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
        $mockBlockCypherRestCall = $this->getMockBuilder('\\BlockCypher\\Transport\\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TransactionConfidenceTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param TransactionConfidence $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\\BlockCypher\\Transport\\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TransactionConfidenceTest::getJson() . ']'
            ));

        $txConfidenceList = Array(TransactionConfidenceTest::getObject()->getTxhash());

        $result = $obj->getMultiple($txConfidenceList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TransactionConfidenceTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return TransactionConfidence
     */
    public static function getObject()
    {
        return new TransactionConfidence(self::getJson());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TransactionConfidence $obj
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
        $mockBlockCypherRestCall = $this->getMockBuilder('\\BlockCypher\\Transport\\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TransactionConfidenceTest::getJson() . ']'
            ));

        $txConfidenceList = Array(TransactionConfidenceTest::getObject()->getTxhash());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->getMultiple($txConfidenceList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}
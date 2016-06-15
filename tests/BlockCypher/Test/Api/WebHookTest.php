<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\WebHook;

/**
 * Class WebHookTest
 *
 * @package BlockCypher\Test\Api
 */
class WebHookTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return WebHook
     */
    public function testSerializationDeserialization()
    {
        $obj = new WebHook(self::getJson());
        $this->assertNotNull($obj);

        $this->assertNotNull($obj->getId());
        $this->assertNotNull($obj->getEvent());
        $this->assertNotNull($obj->getHash());
        $this->assertNotNull($obj->getWalletName());
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getScript());
        $this->assertNotNull($obj->getUrl());
        $this->assertNotNull($obj->getCallbackErrors());
        $this->assertNotNull($obj->getFilter());

        $this->assertEquals(self::getJson(), $obj->toJSON());
        return $obj;
    }

    /**
     * Gets Json String of Object WebHook
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "id": "23beeafe-2f93-4d88-84d9-6cc9acf4d459",
            "token": "c0afcccdde5081d6429de37d16166ead",
            "url": "https://requestb.in/slmm49sl?uniqid=5537d0e823f80",
            "callback_errors": 0,
            "event": "unconfirmed-tx",
            "hash": "2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b",
            "filter": "event=unconfirmed-tx\u0026hash=2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b"
            "wallet_name": "TestWalletName",
            "address": "TestAddress",
            "script": "TestScript",
            "error": "",
            "errors": []
        }
        */
        return '{"id":"23beeafe-2f93-4d88-84d9-6cc9acf4d459","token":"c0afcccdde5081d6429de37d16166ead","url":"https://requestb.in/slmm49sl?uniqid=5537d0e823f80","callback_errors":0,"event":"unconfirmed-tx","hash":"2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b","filter":"event=unconfirmed-tx\u0026hash=2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b","wallet_name":"TestWalletName","address":"TestAddress","script":"TestScript","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param WebHook $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getId(), "23beeafe-2f93-4d88-84d9-6cc9acf4d459");
        $this->assertEquals($obj->getEvent(), "unconfirmed-tx");
        $this->assertEquals($obj->getHash(), "2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b");
        $this->assertEquals($obj->getWalletName(), "TestWalletName");
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getAddress(), "TestAddress");
        $this->assertEquals($obj->getScript(), "TestScript");
        $this->assertEquals($obj->getUrl(), "https://requestb.in/slmm49sl?uniqid=5537d0e823f80");
        $this->assertEquals($obj->getCallbackErrors(), 0);
        // NOTICE: filter string does not contains \u0026 present in json string
        $this->assertEquals($obj->getFilter(), "event=unconfirmed-tx&hash=2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage url is not a fully qualified URL
     */
    public function testUrlValidationForUrl()
    {
        $obj = new WebHook();
        $obj->setUrl(null);
    }

    /**
     * @dataProvider mockProvider
     * @param WebHook $obj
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
     * @param WebHook $obj
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                WebHookTest::getJson()
            ));

        $result = $obj->get("webHookId", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param WebHook $obj
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
                WebHookTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("webHookId", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param WebHook $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . WebHookTest::getJson() . ']'
            ));

        $webHookList = array(WebHookTest::getObject()->getId());

        $result = $obj->getMultiple($webHookList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], WebHookTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return WebHook
     */
    public static function getObject()
    {
        return new WebHook(self::getJson());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param WebHook $obj
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
                '[' . WebHookTest::getJson() . ']'
            ));

        $webHookList = array(WebHookTest::getObject()->getId());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($webHookList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param WebHook $obj
     */
    public function testGetAll($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . WebHookTest::getJson() . ']'
            ));

        $result = $obj->getAll(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], WebHookTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param WebHook $obj
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

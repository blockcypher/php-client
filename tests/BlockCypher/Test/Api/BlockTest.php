<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Block;

/**
 * Class Block
 *
 * @package BlockCypher\Test\Api
 */
class BlockTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return Block
     */
    public function testSerializationDeserialization()
    {
        $obj = new Block(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getHash());
        $this->assertNotNull($obj->getHeight());
        $this->assertNotNull($obj->getChain());
        $this->assertNotNull($obj->getTotal());
        $this->assertNotNull($obj->getFees());
        $this->assertNotNull($obj->getVer());
        $this->assertNotNull($obj->getTime());
        $this->assertNotNull($obj->getReceivedTime());
        $this->assertNotNull($obj->getBits());
        $this->assertNotNull($obj->getNonce());
        $this->assertNotNull($obj->getNTx());
        $this->assertNotNull($obj->getPrevBlock());
        $this->assertNotNull($obj->getMrklRoot());
        $this->assertNotNull($obj->getTxids());
        $this->assertNotNull($obj->getDepth());
        $this->assertNotNull($obj->getPrevBlockUrl());
        $this->assertNotNull($obj->getNextTxids());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object Block
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "hash": "0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328",
            "height": 293000,
            "chain": "BTC.main",
            "total": 288801092067,
            "fees": 6635337,
            "ver": 2,
            "time": "2014-03-29T01:29:19Z",
            "received_time": "2014-12-04T02:52:15.827Z",
            "bits": 419486617,
            "nonce": 704197304,
            "n_tx": 373,
            "prev_block": "0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f",
            "mrkl_root": "5edf6a7e92e65d32843a79227042c215b875675fb92ff9613c90d6964fb069cd",
            "txids": [
            "7f00b52d075b3596cbd37ba5418640ace14a22ed6c5d154c4db5dd80e049b800",
            "a90d9bc04a4e6be53e0ddc47b043625a0bdc849ef3bc05f551bc05336de3a87c",
            "5895df2891075646f6c191206149ba7d65ce5a31edb8d99eea307b254820ad52",
            "502afd1348ff1f3fad6bfb68eb2628856e32fcdd525136e1f5505ecd1aa63366",
            "c342960db1a8c26713953cef86689032f9f57912078101a1f26d0b0d4cb718ee",
            "d50ccb7cd632800cf3b1be83e40a937926574ff796e39eedbd8a1a486a8cc024",
            "efc1776a5b2158e29e59a0c264b82b2986d814beff4061bb7273ef1414bb34e5",
            "a7485748999fe6631b95409df88e74edd1407faefd17fa5ad9978281fa142eab",
            "a9a5acad7e9ae8365471f8176c4004fa69a8808c0e0ba466fa943b96af502229",
            "f55121a5b6f1f697e0d95e8eec7e5b8398ac8320e3d664a978b7030957872281",
            "a73464326b2f2bb600362ef53d92f4a261e36d966f9ecb97e618acc0a37fcd90",
            "d4034361031b08279d115fb303d7efa174b958d0816aac82d8b858546f716028",
            "9ec77781b6b3437ea94d54dfe0a42e9a1a32aa47f2096e6bc7e6fb551958bb47",
            "ee41b6903945d6cd852a2d13d5b7329d0293909993886de8714e7987bc141db8",
            "5848763ec4c71d4d464302910118cdb5594014ca491983c0e34501e13596b227",
            "7c75cebdb66bd7d39d75f01be5cd59dd098624f1efe4260057776659c43fe2b7",
            "e2d0bee4bc5b1c74c053ddaaaa476f7198658e5dd47526a1eee0a46f900ec635",
            "ee4ab06c9f28f044274c45644b6f09b37b3ff66152d4ee28e67c9f26e444d3f4",
            "77fba09a3e6cc6a78ce68f57b7eaf2202e8a3c732c67e4ccfa2bd5144f4f711d",
            "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449"
            ],
            "depth": 59099,
            "prev_block_url": "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f",
            "tx_url": "https://api.blockcypher.com/v1/btc/main/txs/",
            "next_txids": "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328?txstart=20\u0026limit=20",
            "error": "",
            "errors": []
        }
        */

        return '{"hash":"0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328","height":293000,"chain":"BTC.main","total":288801092067,"fees":6635337,"ver":2,"time":"2014-03-29T01:29:19Z","received_time":"2014-12-04T02:52:15.827Z","bits":419486617,"nonce":704197304,"n_tx":373,"prev_block":"0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f","mrkl_root":"5edf6a7e92e65d32843a79227042c215b875675fb92ff9613c90d6964fb069cd","txids":["7f00b52d075b3596cbd37ba5418640ace14a22ed6c5d154c4db5dd80e049b800","a90d9bc04a4e6be53e0ddc47b043625a0bdc849ef3bc05f551bc05336de3a87c","5895df2891075646f6c191206149ba7d65ce5a31edb8d99eea307b254820ad52","502afd1348ff1f3fad6bfb68eb2628856e32fcdd525136e1f5505ecd1aa63366","c342960db1a8c26713953cef86689032f9f57912078101a1f26d0b0d4cb718ee","d50ccb7cd632800cf3b1be83e40a937926574ff796e39eedbd8a1a486a8cc024","efc1776a5b2158e29e59a0c264b82b2986d814beff4061bb7273ef1414bb34e5","a7485748999fe6631b95409df88e74edd1407faefd17fa5ad9978281fa142eab","a9a5acad7e9ae8365471f8176c4004fa69a8808c0e0ba466fa943b96af502229","f55121a5b6f1f697e0d95e8eec7e5b8398ac8320e3d664a978b7030957872281","a73464326b2f2bb600362ef53d92f4a261e36d966f9ecb97e618acc0a37fcd90","d4034361031b08279d115fb303d7efa174b958d0816aac82d8b858546f716028","9ec77781b6b3437ea94d54dfe0a42e9a1a32aa47f2096e6bc7e6fb551958bb47","ee41b6903945d6cd852a2d13d5b7329d0293909993886de8714e7987bc141db8","5848763ec4c71d4d464302910118cdb5594014ca491983c0e34501e13596b227","7c75cebdb66bd7d39d75f01be5cd59dd098624f1efe4260057776659c43fe2b7","e2d0bee4bc5b1c74c053ddaaaa476f7198658e5dd47526a1eee0a46f900ec635","ee4ab06c9f28f044274c45644b6f09b37b3ff66152d4ee28e67c9f26e444d3f4","77fba09a3e6cc6a78ce68f57b7eaf2202e8a3c732c67e4ccfa2bd5144f4f711d","f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449"],"depth":59099,"prev_block_url":"https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f","tx_url":"https://api.blockcypher.com/v1/btc/main/txs/","next_txids":"https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328?txstart=20\u0026limit=20","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param Block $obj
     */
    public function testGetters($obj)
    {
        $txids = array(
            "7f00b52d075b3596cbd37ba5418640ace14a22ed6c5d154c4db5dd80e049b800",
            "a90d9bc04a4e6be53e0ddc47b043625a0bdc849ef3bc05f551bc05336de3a87c",
            "5895df2891075646f6c191206149ba7d65ce5a31edb8d99eea307b254820ad52",
            "502afd1348ff1f3fad6bfb68eb2628856e32fcdd525136e1f5505ecd1aa63366",
            "c342960db1a8c26713953cef86689032f9f57912078101a1f26d0b0d4cb718ee",
            "d50ccb7cd632800cf3b1be83e40a937926574ff796e39eedbd8a1a486a8cc024",
            "efc1776a5b2158e29e59a0c264b82b2986d814beff4061bb7273ef1414bb34e5",
            "a7485748999fe6631b95409df88e74edd1407faefd17fa5ad9978281fa142eab",
            "a9a5acad7e9ae8365471f8176c4004fa69a8808c0e0ba466fa943b96af502229",
            "f55121a5b6f1f697e0d95e8eec7e5b8398ac8320e3d664a978b7030957872281",
            "a73464326b2f2bb600362ef53d92f4a261e36d966f9ecb97e618acc0a37fcd90",
            "d4034361031b08279d115fb303d7efa174b958d0816aac82d8b858546f716028",
            "9ec77781b6b3437ea94d54dfe0a42e9a1a32aa47f2096e6bc7e6fb551958bb47",
            "ee41b6903945d6cd852a2d13d5b7329d0293909993886de8714e7987bc141db8",
            "5848763ec4c71d4d464302910118cdb5594014ca491983c0e34501e13596b227",
            "7c75cebdb66bd7d39d75f01be5cd59dd098624f1efe4260057776659c43fe2b7",
            "e2d0bee4bc5b1c74c053ddaaaa476f7198658e5dd47526a1eee0a46f900ec635",
            "ee4ab06c9f28f044274c45644b6f09b37b3ff66152d4ee28e67c9f26e444d3f4",
            "77fba09a3e6cc6a78ce68f57b7eaf2202e8a3c732c67e4ccfa2bd5144f4f711d",
            "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449"
        );

        $this->assertEquals($obj->getHash(), "0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328");
        $this->assertEquals($obj->getHeight(), 293000);
        $this->assertEquals($obj->getChain(), "BTC.main");
        $this->assertEquals($obj->getTotal(), 288801092067);
        $this->assertEquals($obj->getFees(), 6635337);
        $this->assertEquals($obj->getVer(), 2);
        $this->assertEquals($obj->getTime(), "2014-03-29T01:29:19Z");
        $this->assertEquals($obj->getReceivedTime(), "2014-12-04T02:52:15.827Z");
        $this->assertEquals($obj->getBits(), 419486617);
        $this->assertEquals($obj->getNonce(), 704197304);
        $this->assertEquals($obj->getNTx(), 373);
        $this->assertEquals($obj->getPrevBlock(), "0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f");
        $this->assertEquals($obj->getMrklRoot(), "5edf6a7e92e65d32843a79227042c215b875675fb92ff9613c90d6964fb069cd");
        $this->assertEquals($obj->getTxids(), $txids);
        $this->assertEquals($obj->getDepth(), 59099);
        $this->assertEquals($obj->getPrevBlockUrl(), "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000b358b3b54788547080f49ed52392c2ed32a241951e2c9d5f");
        $this->assertEquals($obj->getTxUrl(), "https://api.blockcypher.com/v1/btc/main/txs/");
        // NOTICE: \u0026 in json is replaced by & in the object
        $this->assertEquals($obj->getNextTxids(), "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328?txstart=20&limit=20");
        $this->assertNotEquals($obj->getNextTxids(), "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328?txstart=20\u0026limit=20");
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     */
    public function testGetWithHash($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $result = $obj->get("0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     */
    public function testGetWithHashAndParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->get("0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328", $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     */
    public function testGetWithHeight($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $result = $obj->get("293000", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     */
    public function testGetWithHeightAndParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockTest::getJson()
            ));

        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->get("293000", $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Block $obj
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
                BlockTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("293000", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     * @param $mockApiContext
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());

        /** @noinspection PhpParamsInspection */
        $result = $obj->getMultiple($blockList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], BlockTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return Block
     */
    public static function getObject()
    {
        return new Block(self::getJson());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Block $obj
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
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($blockList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Block $obj
     */
    public function testGetMultipleWithParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . BlockTest::getJson() . ']'
            ));

        $blockList = Array(BlockTest::getObject()->getHeight());
        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = $obj->getMultiple($blockList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], BlockTest::getObject());
    }
}
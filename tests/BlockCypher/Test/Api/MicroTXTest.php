<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\MicroTX;

/**
 * Class MicroTXTest
 *
 * @package BlockCypher\Test\Api
 */
class MicroTXTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return MicroTX
     */
    public function testSerializationDeserialization()
    {
        $obj = new MicroTX(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getFromPubkey());
        $this->assertNotNull($obj->getFromPrivate());
        $this->assertNotNull($obj->getFromWif());
        $this->assertNotNull($obj->getToAddress());
        $this->assertNotNull($obj->getValueSatoshis());
        $this->assertNotNull($obj->getToken());
        $this->assertNotNull($obj->getChangeAddress());
        $this->assertNotNull($obj->getWaitGuarantee());
        $this->assertNotNull($obj->getTosign());
        $this->assertNotNull($obj->getSignatures());
        $this->assertNotNull($obj->getInputs());
        $this->assertNotNull($obj->getOutputs());
        $this->assertNotNull($obj->getFees());
        $this->assertNotNull($obj->getHash());

        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * Gets Json String of Object Block
     * @return string
     */
    /** @noinspection SpellCheckingInspection */
    public static function getJson()
    {
        /*
        {
            "from_pubkey": "02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543",
            "from_private": "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff",
            "from_wif": "BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ",
            "to_address": "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
            "value_satoshis": 10000,
            "tosign": [
                "488e6defc3f3d26a20505730a1c64b8a3499e225f1bbd8a0e1b51b38251eed0a"
            ],
            "token": "c0afcccdde5081d6429de37d16166ead",
            "change_address": "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
            "wait_guarantee": true,
            "inputs": [
                {
                    "prev_hash": "5da0d6dd64a08b7a4f3fa0c9cbe127121cefa2378763e3aa7737ed50bac5429f",
                    "output_index": 2
                },
                {
                    "prev_hash": "6b1c30cad97df956cfcb47b4cd471bb69112fb726b0fb129575337e3fb9f2c1a",
                    "output_index": 1
                }
            ],
            "outputs": [
                {
                    "address": "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi",
                    "value": 10000
                },
                {
                    "address": "CEyQhiXPtWk8q7hMkv2Kg728i4PYDM9qxf",
                    "value": 9996325
                },
                {
                    "address": "C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm",
                    "value": 5352100
                }
            ],
            "fees": 735,
            "signatures": [
                "3045022100f99bef2add7d1fd9c771a530b8baf50fc080a95dc3c5abc4a9e520932ecaf2ca02204ab0ac7a9abf62470172eac9a9a285d711bb450026a15d6d64d8ae19ec090373"
            ],
            "hash": "7fc9e41e6ef29486bc4478ff063934ea9a1ecd08bbfb0a207b39ad92fe55bebf",
            "error": "",
            "errors": []
        }
        */

        $inputs = TXInputTest::getJson();
        $outputs = TXOutputTest::getJson();

        /** @noinspection SpellCheckingInspection */
        return '{"from_pubkey":"02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543","from_private":"2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff","from_wif":"BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ","to_address":"C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi","value_satoshis":10000,"tosign":["488e6defc3f3d26a20505730a1c64b8a3499e225f1bbd8a0e1b51b38251eed0a"],"token":"c0afcccdde5081d6429de37d16166ead","change_address":"C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi","wait_guarantee":true,"inputs":[' . $inputs . '],"outputs":[' . $outputs . '],"fees":735,"signatures":["3045022100f99bef2add7d1fd9c771a530b8baf50fc080a95dc3c5abc4a9e520932ecaf2ca02204ab0ac7a9abf62470172eac9a9a285d711bb450026a15d6d64d8ae19ec090373"],"hash":"7fc9e41e6ef29486bc4478ff063934ea9a1ecd08bbfb0a207b39ad92fe55bebf","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param MicroTX $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getFromPubkey(), "02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543");
        $this->assertEquals($obj->getFromPrivate(), "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff");
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getFromWif(), "BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ");
        $this->assertEquals($obj->getToAddress(), "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
        $this->assertEquals($obj->getValueSatoshis(), 10000);
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getToken(), "c0afcccdde5081d6429de37d16166ead");
        $this->assertEquals($obj->getChangeAddress(), "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
        $this->assertEquals($obj->getWaitGuarantee(), true);
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getTosign(), array("488e6defc3f3d26a20505730a1c64b8a3499e225f1bbd8a0e1b51b38251eed0a"));
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getSignatures(), array("3045022100f99bef2add7d1fd9c771a530b8baf50fc080a95dc3c5abc4a9e520932ecaf2ca02204ab0ac7a9abf62470172eac9a9a285d711bb450026a15d6d64d8ae19ec090373"));
        $this->assertEquals($obj->getInputs(), array(TXInputTest::getObject()));
        $this->assertEquals($obj->getOutputs(), array(TXOutputTest::getObject()));
        $this->assertEquals($obj->getFees(), 735);
        $this->assertEquals($obj->getHash(), "7fc9e41e6ef29486bc4478ff063934ea9a1ecd08bbfb0a207b39ad92fe55bebf");
    }

    /**
     * @dataProvider mockProvider
     * @param MicroTX $obj
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
     * @param MicroTX $obj
     */
    public function testSend($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                self::getJson()
            ));

        $result = $obj->send($mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    public function testSign()
    {
        $obj = static::getObject();

        $hexPrivateKey = "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff";
        $expectedSignatures = array("3045022100f99bef2add7d1fd9c771a530b8baf50fc080a95dc3c5abc4a9e520932ecaf2ca02204ab0ac7a9abf62470172eac9a9a285d711bb450026a15d6d64d8ae19ec090373");

        $obj->sign($hexPrivateKey);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return MicroTX
     */
    public static function getObject()
    {
        return new MicroTX(self::getJson());
    }
}
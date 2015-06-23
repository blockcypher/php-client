<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\TXSkeleton;

/**
 * Class TXSkeletonTest
 *
 * @package BlockCypher\Test\Api
 */
class TXSkeletonTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return TXSkeleton
     */
    public function testSerializationDeserialization()
    {
        $obj = new TXSkeleton(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getTx());
        $this->assertNotNull($obj->getTosign());
        $this->assertNotNull($obj->getSignatures());
        $this->assertNotNull($obj->getPubkeys());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object TXSkeleton
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "tx":{
                "block_height":-1,
                "hash":"d8362a84c6b51015abaec80f4dcc008a38dff3ec8ac4bbc9a31d5f79a28bc2d7",
                "addresses":[
                    "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4",
                    "mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj"
                ],
                "total":38000,
                "fees":12000,
                "size":119,
                "preference":"high",
                "relayed_by":"2.138.21.40",
                "received":"2015-06-08T22:18:06.778942901Z",
                "ver":1,
                "lock_time":0,
                "double_spend":false,
                "vin_sz":1,
                "vout_sz":2,
                "confirmations":0,
                "inputs":[
                    {
                        "prev_hash":"c719e0c52f63d9afbb72b00324499c0510672fa63c205db982188161ee3f105c",
                        "output_index":0,
                        "script":"",
                        "output_value":50000,
                        "sequence":4294967295,
                        "addresses":[
                            "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
                        ],
                        "script_type":"",
                        "age":2
                    }
                ],
                "outputs":[
                    {
                        "value":1000,
                        "script":"76a914a93806b8ae200fffca565f7cf9ef3ab17d4ffe8888ac",
                        "addresses":[
                            "mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj"
                        ],
                        "script_type":"pay-to-pubkey-hash"
                    },
                    {
                        "value":37000,
                        "script":"76a914edeed3ce7f485e44bc33969af08ec9250510f83f88ac",
                        "addresses":[
                            "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
                        ],
                        "script_type":"pay-to-pubkey-hash"
                    }
                ]
            },
            "tosign":[
                "7e6a71a683f303b6a659daa8009c81c47edd2b14f59b938cb31f8ef2a3e129f5"
            ],
            "signatures":[
                "30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b"
            ],
            "pubkeys":[
                "0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf"
            ],
            "error": "",
            "errors": []
        }
        */

        $tx = TXTest::getJson();
        return '{"tx":' . $tx . ',"tosign":["7e6a71a683f303b6a659daa8009c81c47edd2b14f59b938cb31f8ef2a3e129f5"],"signatures":["30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b"],"pubkeys":["0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf"],"error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param TXSkeleton $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getTx(), TXTest::getObject());
        $this->assertEquals($obj->getTosign(), array("7e6a71a683f303b6a659daa8009c81c47edd2b14f59b938cb31f8ef2a3e129f5"));
        $this->assertEquals($obj->getSignatures(), array("30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b"));
        $this->assertEquals($obj->getPubkeys(), array("0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf"));
    }

    /**
     * @dataProvider mockProvider
     * @param TXSkeleton $obj
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
     * @param TXSkeleton $obj
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

        $mockApiContext = $this->getMockBuilder('\BlockCypher\Rest\ApiContext')
            ->disableOriginalConstructor()
            ->setMethods(array('getCoinSymbol'))
            ->getMock();

        $mockApiContext->expects($this->once())
            ->method('getCoinSymbol')
            ->will($this->returnValue("btc-testnet"));

        $hexPrivateKey = "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e";
        $expectedSignatures = array("30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b");

        /** @noinspection PhpParamsInspection */
        $obj->sign($hexPrivateKey, $mockApiContext);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return TXSkeleton
     */
    public static function getObject()
    {
        return new TXSkeleton(self::getJson());
    }
}
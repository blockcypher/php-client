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
        $this->assertNotNull($obj->getError());
        $this->assertNotNull($obj->getErrors());

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
            "error": "message",
            "errors": []
        }
        */

        $tx = TXTest::getJson();
        return '{"tx":' . $tx . ',"tosign":["7e6a71a683f303b6a659daa8009c81c47edd2b14f59b938cb31f8ef2a3e129f5"],"signatures":["30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b"],"pubkeys":["0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf"],"error":"message","errors":[]}';
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
        $this->assertEquals($obj->getError(), "message");
        $this->assertEquals($obj->getErrors(), array());
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

        $coinSymbol = 'btc-testnet';
        $hexPrivateKey = "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e";
        $expectedPubkeys = array("0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf");
        $expectedSignatures = array("30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b");

        /** @noinspection PhpParamsInspection */
        $obj->sign($hexPrivateKey, $coinSymbol);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
        $this->assertEquals($expectedPubkeys, $obj->getPubkeys());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return TXSkeleton
     */
    public static function getObject()
    {
        return new TXSkeleton(self::getJson());
    }

    public function testMultiSig3of3()
    {
        $obj = static::getMultisigObject();

        $coinSymbol = 'btc-testnet';
        $hexPrivateKeys = static::getMultisigPrivateKeys();
        $pubKeys = static::getMultisigPublicKeys();
        $signatures = static::getMultisigSignatures();

        $threePrivateKeys = array(
            $hexPrivateKeys[0],
            $hexPrivateKeys[1],
            $hexPrivateKeys[2]
        );
        $expectedSignatures = array(
            $signatures['tosign0']['privKey0'],
            $signatures['tosign0']['privKey1'],
            $signatures['tosign0']['privKey2'],
            $signatures['tosign1']['privKey0'],
            $signatures['tosign1']['privKey1'],
            $signatures['tosign1']['privKey2'],
            $signatures['tosign2']['privKey0'],
            $signatures['tosign2']['privKey1'],
            $signatures['tosign2']['privKey2']
        );
        $expectedPubkeys = array(
            $pubKeys[0],
            $pubKeys[1],
            $pubKeys[2],
            $pubKeys[0],
            $pubKeys[1],
            $pubKeys[2],
            $pubKeys[0],
            $pubKeys[1],
            $pubKeys[2]
        );

        /** @noinspection PhpParamsInspection */
        $obj->sign($threePrivateKeys, $coinSymbol);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
        $this->assertEquals($expectedPubkeys, $obj->getPubkeys());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return TXSkeleton
     */
    public static function getMultisigObject()
    {
        return new TXSkeleton(self::getMultisigJson());
    }

    /**
     * Gets Json String of Object TXSkeleton
     * @return string
     */
    public static function getMultisigJson()
    {
        /*
        {
            "errors": [
                {
                    "error": "Not enough funds after fees in 3 inputs to pay for 1 outputs, missing -6200."
                }
            ],
            "tx": {
                "block_height": -1,
                "hash": "59dca8cd1cac56c58bcaeba43fd451791a448cecbfd09d4925695ab0f82e7c14",
                "addresses": [
                    "2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ",
                    "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
                ],
                "total": 1000,
                "fees": 51000,
                "size": 167,
                "preference": "high",
                "relayed_by": "83.37.162.102",
                "received": "2015-07-20T08:42:12.712907487Z",
                "ver": 1,
                "lock_time": 0,
                "double_spend": false,
                "vin_sz": 3,
                "vout_sz": 1,
                "confirmations": 0,
                "inputs": [
                    {
                        "prev_hash": "7f130e3f7dda2ca51632a5a87b1b8a8b53e2706ad9240d2f765d5c1036d70281",
                        "output_index": 0,
                        "script": "",
                        "output_value": 1000,
                        "sequence": 4294967295,
                        "addresses": [
                            "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
                            "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
                            "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
                        ],
                        "script_type": "multisig-2-of-3",
                        "age": 22720
                    },
                    {
                        "prev_hash": "16a26118d0a69665057b23f50e641760d867380c744322b0e057ace05eb92b87",
                        "output_index": 0,
                        "script": "",
                        "output_value": 1000,
                        "sequence": 4294967295,
                        "addresses": [
                            "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
                            "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
                            "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
                        ],
                        "script_type": "multisig-2-of-3",
                        "age": 22715
                    },
                    {
                        "prev_hash": "7946b37103ec6993a5a3f52dd2658a9e09d78a2484d172a64b67cc8f4aec1931",
                        "output_index": 0,
                        "script": "",
                        "output_value": 50000,
                        "sequence": 4294967295,
                        "addresses": [
                            "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
                            "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
                            "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
                        ],
                        "script_type": "multisig-2-of-3",
                        "age": 22694
                    }
                ],
                "outputs": [
                    {
                        "value": 1000,
                        "script": "76a914edeed3ce7f485e44bc33969af08ec9250510f83f88ac",
                        "addresses": [
                            "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
                        ],
                        "script_type": "pay-to-pubkey-hash"
                    }
                ]
            },
            "tosign": [
                "66c89208140058dca1ea9210d5b0304371734398ed29e4fb9b3d3d360ab980ce",
                "1567ee28b7d112e231b9dd9fabdc3c0af1178d20565deb68cd33ab997a8c9567",
                "1c22f516a685b5245bcc8788a4cc2d1854c0ad8515b9f3f758443c318f717656"
            ]
        }
        */

        return '{"errors":[{"error":"Notenoughfundsafterfeesin3inputstopayfor1outputs,missing-6200."}],"tx":{"block_height":-1,"hash":"59dca8cd1cac56c58bcaeba43fd451791a448cecbfd09d4925695ab0f82e7c14","addresses":["2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ","n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"],"total":1000,"fees":51000,"size":167,"preference":"high","relayed_by":"83.37.162.102","received":"2015-07-20T08:42:12.712907487Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":3,"vout_sz":1,"confirmations":0,"inputs":[{"prev_hash":"7f130e3f7dda2ca51632a5a87b1b8a8b53e2706ad9240d2f765d5c1036d70281","output_index":0,"script":"","output_value":1000,"sequence":4294967295,"addresses":["03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81","03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1","03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"],"script_type":"multisig-2-of-3","age":22720},{"prev_hash":"16a26118d0a69665057b23f50e641760d867380c744322b0e057ace05eb92b87","output_index":0,"script":"","output_value":1000,"sequence":4294967295,"addresses":["03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81","03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1","03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"],"script_type":"multisig-2-of-3","age":22715},{"prev_hash":"7946b37103ec6993a5a3f52dd2658a9e09d78a2484d172a64b67cc8f4aec1931","output_index":0,"script":"","output_value":50000,"sequence":4294967295,"addresses":["03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81","03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1","03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"],"script_type":"multisig-2-of-3","age":22694}],"outputs":[{"value":1000,"script":"76a914edeed3ce7f485e44bc33969af08ec9250510f83f88ac","addresses":["n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"],"script_type":"pay-to-pubkey-hash"}]},"tosign":["66c89208140058dca1ea9210d5b0304371734398ed29e4fb9b3d3d360ab980ce","1567ee28b7d112e231b9dd9fabdc3c0af1178d20565deb68cd33ab997a8c9567","1c22f516a685b5245bcc8788a4cc2d1854c0ad8515b9f3f758443c318f717656"]}';
    }

    public static function getMultisigPrivateKeys()
    {
        $hexPrivateKeys = array(
            'a2d2a8aa1cb1dbf7780d99aece481be1cd7d79427618a6091cf9b0d9d1244210',
            'd6dd853fa8c294c8178eac620fb7c58e98813dcf3a85c012786280bab4662ed8',
            'b0b730309a90eabc7681a47facf3f8bcaeb68668d2eaf8a2fe52682144d61418'
        );

        return $hexPrivateKeys;
    }

    public static function getMultisigPublicKeys()
    {
        $pubKeys = array(
            '03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81',
            '03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1',
            '03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02'
        );

        return $pubKeys;
    }

    public static function getMultisigSignatures()
    {
        $signatures = array(
            'tosign0' => array(
                'privKey0' => '3045022100ed1808ed3b715c7b4df5ab3f4413478a86ef60361cd466ed6537e0a767e1d68102201e8f4efd33368d510b36e296f4c19c156de47a0cbd1ab20c9f69fb4e3721e3e2',
                'privKey1' => '30440220597287ac3143fac96312890e8c893cacb20651dbb11159f263d8152840a02429022057ab538d5723a16d07f2268ad87f353d23eee1acb6bcd95a9878dd29e93cf564',
                'privKey2' => '3044022022e6f6ee5470948bcf361f75e0b6086592b9d5572c480add86ca66ce6642da26022000e684edb83329aa275a32343bbce122299c7b53eae8166268f9ad6a37fe5053',
            ),
            'tosign1' => array(
                'privKey0' => '3045022100b61d2389971d9b307e6d707b946a6c4534baa8f7a8f8c353f4df23e392e09e680220506426db234dbe12e5e07849f77dca98176fbd8f0ed681ad87f2387ca17cd925',
                'privKey1' => '3044022042764d62c2056fb9bfe4ec3d11f4b20457ec271603af84de0a9a601f26fe1fc702201cc17f1d72783bbcbe2baca004537d2a218a96c0696cd0a29ed49a62b8144157',
                'privKey2' => '3045022100c45c0d57fc6e43845f0a5dd889c10202d11c374f8dc28688d195157f91e0bee702204323208b25c853bd5c104a1979dc1e64e43ba733d2ea78544fedd2129fb26ad9',
            ),
            'tosign2' => array(
                'privKey0' => '3045022100eec1c3971f464f7debf5a92ee53b466b6ecb936674ade16f791c2fe57782483f022028b7d15ab1a7f0b246cd0f59d75e9921178ca256b4068167e2095c44ae033966',
                'privKey1' => '30450221008a87491e7b52a15e55428f55e96e82087bb9ac90180a91174945f0f2e7d2796802206f1151c34f5924f7dfff6add2286376fa0b30e7bd30f33899e2584df24b3e7ad',
                'privKey2' => '3045022100ecd3e058095bad5867aa1b4ef93a4d50ab2cf43e22968968256e3c9221a06b5b02205c63edff268f4c9de5d192ffeda45f6436a1a1fa09628f6b0bcd1a6ad9549bcf',
            )
        );

        return $signatures;
    }

    public function testMultiSig2of3()
    {
        $obj = static::getMultisigObject();

        $coinSymbol = 'btc-testnet';
        $hexPrivateKeys = static::getMultisigPrivateKeys();
        $pubKeys = static::getMultisigPublicKeys();
        $signatures = static::getMultisigSignatures();

        $twoPrivateKeys = array(
            $hexPrivateKeys[0],
            $hexPrivateKeys[1]
        );
        $expectedSignatures = array(
            $signatures['tosign0']['privKey0'],
            $signatures['tosign0']['privKey1'],
            $signatures['tosign1']['privKey0'],
            $signatures['tosign1']['privKey1'],
            $signatures['tosign2']['privKey0'],
            $signatures['tosign2']['privKey1'],
        );
        $expectedPubkeys = array(
            $pubKeys[0],
            $pubKeys[1],
            $pubKeys[0],
            $pubKeys[1],
            $pubKeys[0],
            $pubKeys[1],
        );

        /** @noinspection PhpParamsInspection */
        $obj->sign($twoPrivateKeys, $coinSymbol);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
        $this->assertEquals($expectedPubkeys, $obj->getPubkeys());
    }

    public function testMultiSig1of3()
    {
        $obj = static::getMultisigObject();

        $coinSymbol = 'btc-testnet';
        $hexPrivateKeys = static::getMultisigPrivateKeys();
        $pubKeys = static::getMultisigPublicKeys();
        $signatures = static::getMultisigSignatures();

        $onePrivateKeys = array(
            $hexPrivateKeys[0]
        );
        $expectedSignatures = array(
            $signatures['tosign0']['privKey0'],
            $signatures['tosign1']['privKey0'],
            $signatures['tosign2']['privKey0']
        );
        $expectedPubkeys = array(
            $pubKeys[0],
            $pubKeys[0],
            $pubKeys[0]
        );

        /** @noinspection PhpParamsInspection */
        $obj->sign($onePrivateKeys, $coinSymbol);
        $this->assertEquals($expectedSignatures, $obj->getSignatures());
        $this->assertEquals($expectedPubkeys, $obj->getPubkeys());
    }
}
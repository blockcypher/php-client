<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\FullAddress;

/**
 * Class FullWalletAsFullAddressTest
 *
 * This test case only tests FullAddress class when it is used with a wallet instead of an address.
 *
 * @package BlockCypher\Test\Api
 */
class FullWalletAsFullAddressTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return FullAddress
     */
    public static function getObject()
    {
        return new FullAddress(self::getJson());
    }

    /**
     * Gets Json String of Object Address
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "wallet": {
                "token": "c0afcccdde5081d6429de37d16166ead",
                "name": "alice",
                "addresses": [
                    "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
                    "1JDHBHESobzLpRP9QhNqDDY5kkBFGcRq2M",
                    "1JWARATTPYKLUgZj3c1U1EsrGPq6FUQPF3",
                    "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e",
                    "1jr1rHMthQVMNSYswB9ExSvYn339fWMzn"
                ]
            },
            "total_received": 231765,
            "total_sent": 182465,
            "balance": 49300,
            "unconfirmed_balance": 0,
            "final_balance": 0,
            "n_tx": 3,
            "unconfirmed_n_tx": 0,
            "final_n_tx": 0,
            "txs": [
                {
                    "block_hash": "000000000000000012c280d3ed5d737ceae1da39de07c49762e6e15b0bb076c9",
                    "block_height": 359108,
                    "hash": "dbc870fd7786656d41f1b55f920fc6dd5619534764e99bf14ebb2278e71a9d8a",
                    "addresses": [
                        "15Wb4DLZAipDXiNQ3HcjofDDtcVzkW9qLY",
                        "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
                        "19ASTyhb61Z335An2KhLVZUPrhmFcCDv2j",
                        "1H21GhNYBuCGqvcNM4d5yHv7J7b73xnnq2",
                        "1HourZ4jGvyEhiLko9iNVX49zegNBdiTDH"
                    ],
                    "total": 4319535,
                    "fees": 10000,
                    "size": 407,
                    "preference": "medium",
                    "relayed_by": "69.65.13.94:8333",
                    "confirmed": "2015-06-02T15:38:43Z",
                    "received": "2015-06-02T15:38:15.165Z",
                    "ver": 1,
                    "lock_time": 0,
                    "double_spend": false,
                    "vin_sz": 2,
                    "vout_sz": 3,
                    "confirmations": 408,
                    "confidence": 1,
                    "inputs": [
                        {
                            "prev_hash": "6b6bb92cc8ae0a57e2a6bc067134954f7ae73f865a662d25e7d00dc0c5b13b91",
                            "output_index": 1,
                            "script": "4730440220169bf919c94e0e1e1b864ad64d7405cf1d23087c9bae7a7ee89a04ea7019d9bc02206a09326af020b1f71d7e86fa25f67cdb9ec01ebf9b278022ba6994c6600e7f42012103a158084675fb838b0328e3fb25e86cfc8030c179d1ba87b98ae42487a396b604",
                            "output_value": 4268714,
                            "sequence": 4294967295,
                            "addresses": [
                                "19ASTyhb61Z335An2KhLVZUPrhmFcCDv2j"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        },
                        {
                            "prev_hash": "1fbefcbe10d47bcb459c105b5e4b9e28478d0b1ccfbea539ab0c566dcad78f15",
                            "output_index": 1,
                            "script": "483045022072a9e0f62c5df3aa0beb899926c39ea2ea0e981a7bc54d4a1ffc079eb1fa3531022100ab3259e4830938f42299032fd7123ac82ea183c593cd5721da4dba36d8a250d3012102364691ad0244f40d977f6e58cfe7648eb796f73dcf57a5f6695feee2b650341b",
                            "output_value": 60821,
                            "sequence": 4294967295,
                            "addresses": [
                                "15Wb4DLZAipDXiNQ3HcjofDDtcVzkW9qLY"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ],
                    "outputs": [
                        {
                            "value": 49300,
                            "script": "76a914521cdbfe61b9e65bd7165cb47a463f4d1e77a7a888ac",
                            "addresses": [
                                "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        },
                        {
                            "value": 4219414,
                            "script": "76a914b86144730246a8854e6244e5b3ff5c23b0111a9c88ac",
                            "spent_by": "e32689c318e33a3ef0d132266e7226719fd9ac5f356f487e37baa671daf735b3",
                            "addresses": [
                                "1HourZ4jGvyEhiLko9iNVX49zegNBdiTDH"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        },
                        {
                            "value": 50821,
                            "script": "76a914afb2a787240d0b059da8f5676a38215d84bf7ef288ac",
                            "spent_by": "d8e9a17348f921f24269c2bfa7bdb5e73d2d2ce725581e1dcd449410cd4dc6b1",
                            "addresses": [
                                "1H21GhNYBuCGqvcNM4d5yHv7J7b73xnnq2"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ]
                },
                {
                    "block_hash": "00000000000000001e2a747856b05c01cb56247ab64895699f1ee2ba8890e572",
                    "block_height": 318279,
                    "hash": "a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b",
                    "addresses": [
                        "1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n",
                        "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
                    ],
                    "total": 172465,
                    "fees": 10000,
                    "size": 223,
                    "preference": "medium",
                    "relayed_by": "",
                    "confirmed": "2014-08-30T16:42:15Z",
                    "received": "2014-08-30T16:42:15Z",
                    "ver": 1,
                    "lock_time": 0,
                    "double_spend": false,
                    "vin_sz": 1,
                    "vout_sz": 1,
                    "confirmations": 41237,
                    "confidence": 1,
                    "inputs": [
                        {
                            "prev_hash": "745f870ae1bc05d6d503b63a25e8681d986c19997997143992f718a7497f392f",
                            "output_index": 0,
                            "script": "473044022073f1c214bb520c3e750d0ee87761f9a3d6afa276cfa01a22a03d094754ac1e4a022053ec725ea446f7a3d1d7a434a2f10cdf63cabe4e7c08d2a7aa533022beb87028014104a5c1216fb9a01b0f049d5ed5501289f4fca4aaabe0085387d13294da5e6313deda7cd5884adfc278ed72053c2c08653f1f14449eac8bfdc7a7d52b8ded749782",
                            "output_value": 182465,
                            "sequence": 4294967295,
                            "addresses": [
                                "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ],
                    "outputs": [
                        {
                            "value": 172465,
                            "script": "76a91467e252fd5e287fd843bde43a93ec5fcf10d3ca5688ac",
                            "spent_by": "134c2002055e98ea01157be173324a0f78a8e7e3c94f6b322d5d0b61fdaf1c88",
                            "addresses": [
                                "1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ]
                },
                {
                    "block_hash": "00000000000000000c445fbf498b749ea492560a357395a7a5ec0a22b16287c5",
                    "block_height": 318060,
                    "hash": "745f870ae1bc05d6d503b63a25e8681d986c19997997143992f718a7497f392f",
                    "addresses": [
                        "1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n",
                        "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
                    ],
                    "total": 2080001,
                    "fees": 10000,
                    "size": 258,
                    "preference": "medium",
                    "relayed_by": "",
                    "confirmed": "2014-08-29T10:29:31Z",
                    "received": "2014-08-29T10:29:31Z",
                    "ver": 1,
                    "lock_time": 0,
                    "double_spend": false,
                    "vin_sz": 1,
                    "vout_sz": 2,
                    "confirmations": 41456,
                    "confidence": 1,
                    "inputs": [
                        {
                            "prev_hash": "3b205dca2059bab0dce2737c8ff94a662e8e73a90d52c6d2e3ebd75d5e44b848",
                            "output_index": 1,
                            "script": "483045022100b5319e5f53463a908281d106a463c2c85b9e51caf1fec7064f01bca0d2f7639602201a26cf968561604f8976c954fe832d1eb339b877e4ed3db2a2c8cfb7f685a20d0141048ff7872fea6d1089c1f39cea386fe196d1c0e12bcc1e74605153f42ff9dfe1bd9105be32e57dbf98eca05efcf19f139f7a14f68399576635ce68bec663018fab",
                            "output_value": 2090001,
                            "sequence": 4294967295,
                            "addresses": [
                                "1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ],
                    "outputs": [
                        {
                            "value": 182465,
                            "script": "76a914c131d3c82a0041d5b39b9e18d2b91418b1cb0ce388ac",
                            "spent_by": "a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b",
                            "addresses": [
                                "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        },
                        {
                            "value": 1897536,
                            "script": "76a91467e252fd5e287fd843bde43a93ec5fcf10d3ca5688ac",
                            "spent_by": "134c2002055e98ea01157be173324a0f78a8e7e3c94f6b322d5d0b61fdaf1c88",
                            "addresses": [
                                "1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"
                            ],
                            "script_type": "pay-to-pubkey-hash"
                        }
                    ]
                }
            ],
            "error": "",
            "errors": []
        }
        */

        $wallet = WalletTest::getJson();

        return '{"wallet":' . $wallet . ',"total_received":231765,"total_sent":182465,"balance":49300,"unconfirmed_balance":0,"final_balance":0,"n_tx":3,"unconfirmed_n_tx":0,"final_n_tx":0,"txs":[{"block_hash":"000000000000000012c280d3ed5d737ceae1da39de07c49762e6e15b0bb076c9","block_height":359108,"hash":"dbc870fd7786656d41f1b55f920fc6dd5619534764e99bf14ebb2278e71a9d8a","addresses":["15Wb4DLZAipDXiNQ3HcjofDDtcVzkW9qLY","18VAyux27CiWQnmYumZeTKNcaw6opvKRLq","19ASTyhb61Z335An2KhLVZUPrhmFcCDv2j","1H21GhNYBuCGqvcNM4d5yHv7J7b73xnnq2","1HourZ4jGvyEhiLko9iNVX49zegNBdiTDH"],"total":4319535,"fees":10000,"size":407,"preference":"medium","relayed_by":"69.65.13.94:8333","confirmed":"2015-06-02T15:38:43Z","received":"2015-06-02T15:38:15.165Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":2,"vout_sz":3,"confirmations":408,"confidence":1,"inputs":[{"prev_hash":"6b6bb92cc8ae0a57e2a6bc067134954f7ae73f865a662d25e7d00dc0c5b13b91","output_index":1,"script":"4730440220169bf919c94e0e1e1b864ad64d7405cf1d23087c9bae7a7ee89a04ea7019d9bc02206a09326af020b1f71d7e86fa25f67cdb9ec01ebf9b278022ba6994c6600e7f42012103a158084675fb838b0328e3fb25e86cfc8030c179d1ba87b98ae42487a396b604","output_value":4268714,"sequence":4294967295,"addresses":["19ASTyhb61Z335An2KhLVZUPrhmFcCDv2j"],"script_type":"pay-to-pubkey-hash"},{"prev_hash":"1fbefcbe10d47bcb459c105b5e4b9e28478d0b1ccfbea539ab0c566dcad78f15","output_index":1,"script":"483045022072a9e0f62c5df3aa0beb899926c39ea2ea0e981a7bc54d4a1ffc079eb1fa3531022100ab3259e4830938f42299032fd7123ac82ea183c593cd5721da4dba36d8a250d3012102364691ad0244f40d977f6e58cfe7648eb796f73dcf57a5f6695feee2b650341b","output_value":60821,"sequence":4294967295,"addresses":["15Wb4DLZAipDXiNQ3HcjofDDtcVzkW9qLY"],"script_type":"pay-to-pubkey-hash"}],"outputs":[{"value":49300,"script":"76a914521cdbfe61b9e65bd7165cb47a463f4d1e77a7a888ac","addresses":["18VAyux27CiWQnmYumZeTKNcaw6opvKRLq"],"script_type":"pay-to-pubkey-hash"},{"value":4219414,"script":"76a914b86144730246a8854e6244e5b3ff5c23b0111a9c88ac","spent_by":"e32689c318e33a3ef0d132266e7226719fd9ac5f356f487e37baa671daf735b3","addresses":["1HourZ4jGvyEhiLko9iNVX49zegNBdiTDH"],"script_type":"pay-to-pubkey-hash"},{"value":50821,"script":"76a914afb2a787240d0b059da8f5676a38215d84bf7ef288ac","spent_by":"d8e9a17348f921f24269c2bfa7bdb5e73d2d2ce725581e1dcd449410cd4dc6b1","addresses":["1H21GhNYBuCGqvcNM4d5yHv7J7b73xnnq2"],"script_type":"pay-to-pubkey-hash"}]},{"block_hash":"00000000000000001e2a747856b05c01cb56247ab64895699f1ee2ba8890e572","block_height":318279,"hash":"a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b","addresses":["1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n","1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"total":172465,"fees":10000,"size":223,"preference":"medium","relayed_by":"","confirmed":"2014-08-30T16:42:15Z","received":"2014-08-30T16:42:15Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":1,"vout_sz":1,"confirmations":41237,"confidence":1,"inputs":[{"prev_hash":"745f870ae1bc05d6d503b63a25e8681d986c19997997143992f718a7497f392f","output_index":0,"script":"473044022073f1c214bb520c3e750d0ee87761f9a3d6afa276cfa01a22a03d094754ac1e4a022053ec725ea446f7a3d1d7a434a2f10cdf63cabe4e7c08d2a7aa533022beb87028014104a5c1216fb9a01b0f049d5ed5501289f4fca4aaabe0085387d13294da5e6313deda7cd5884adfc278ed72053c2c08653f1f14449eac8bfdc7a7d52b8ded749782","output_value":182465,"sequence":4294967295,"addresses":["1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"script_type":"pay-to-pubkey-hash"}],"outputs":[{"value":172465,"script":"76a91467e252fd5e287fd843bde43a93ec5fcf10d3ca5688ac","spent_by":"134c2002055e98ea01157be173324a0f78a8e7e3c94f6b322d5d0b61fdaf1c88","addresses":["1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"],"script_type":"pay-to-pubkey-hash"}]},{"block_hash":"00000000000000000c445fbf498b749ea492560a357395a7a5ec0a22b16287c5","block_height":318060,"hash":"745f870ae1bc05d6d503b63a25e8681d986c19997997143992f718a7497f392f","addresses":["1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n","1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"total":2080001,"fees":10000,"size":258,"preference":"medium","relayed_by":"","confirmed":"2014-08-29T10:29:31Z","received":"2014-08-29T10:29:31Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":1,"vout_sz":2,"confirmations":41456,"confidence":1,"inputs":[{"prev_hash":"3b205dca2059bab0dce2737c8ff94a662e8e73a90d52c6d2e3ebd75d5e44b848","output_index":1,"script":"483045022100b5319e5f53463a908281d106a463c2c85b9e51caf1fec7064f01bca0d2f7639602201a26cf968561604f8976c954fe832d1eb339b877e4ed3db2a2c8cfb7f685a20d0141048ff7872fea6d1089c1f39cea386fe196d1c0e12bcc1e74605153f42ff9dfe1bd9105be32e57dbf98eca05efcf19f139f7a14f68399576635ce68bec663018fab","output_value":2090001,"sequence":4294967295,"addresses":["1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"],"script_type":"pay-to-pubkey-hash"}],"outputs":[{"value":182465,"script":"76a914c131d3c82a0041d5b39b9e18d2b91418b1cb0ce388ac","spent_by":"a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b","addresses":["1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"],"script_type":"pay-to-pubkey-hash"},{"value":1897536,"script":"76a91467e252fd5e287fd843bde43a93ec5fcf10d3ca5688ac","spent_by":"134c2002055e98ea01157be173324a0f78a8e7e3c94f6b322d5d0b61fdaf1c88","addresses":["1AUHj3DKMtTR7jLyxG2XQFQFNSWQPUWy9n"],"script_type":"pay-to-pubkey-hash"}]}],"error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return FullAddress
     */
    public function testSerializationDeserialization()
    {
        $obj = new FullAddress(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getWallet());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param FullAddress $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getWallet(), WalletTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param FullAddress $obj
     */
    public function testGet($obj, /** @noinspection PhpDocSignatureInspection */
                            $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FullWalletAsFullAddressTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("alice", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('BlockCypher\Api\FullAddress', $result);
    }
}
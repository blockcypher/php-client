<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Address;

/**
 * Class WalletAsAddressTest
 *
 * This test case only tests Address class when it is used with a wallet instead of an address.
 *
 * @package BlockCypher\Test\Api
 */
class WalletAsAddressTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Address
     */
    public static function getObject()
    {
        return new Address(self::getJson());
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
            "final_balance": 49300,
            "n_tx": 3,
            "unconfirmed_n_tx": 0,
            "final_n_tx": 3,
            "txrefs": [
                {
                    "address": "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
                    "tx_hash": "dbc870fd7786656d41f1b55f920fc6dd5619534764e99bf14ebb2278e71a9d8a",
                    "block_height": 359108,
                    "tx_input_n": -1,
                    "tx_output_n": 0,
                    "value": 49300,
                    "spent": false,
                    "confirmations": 289,
                    "confirmed": "2015-06-02T15:38:43Z",
                    "double_spend": false
                },
                {
                    "address": "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e",
                    "tx_hash": "a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b",
                    "block_height": 318279,
                    "tx_input_n": 0,
                    "tx_output_n": -1,
                    "value": 182465,
                    "spent": false,
                    "confirmations": 41118,
                    "confirmed": "2014-08-30T16:42:15Z",
                    "double_spend": false
                },
                {
                    "address": "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e",
                    "tx_hash": "745f870ae1bc05d6d503b63a25e8681d986c19997997143992f718a7497f392f",
                    "block_height": 318060,
                    "tx_input_n": -1,
                    "tx_output_n": 0,
                    "value": 182465,
                    "spent": true,
                    "spent_by": "a36293bdc89877bc7b0474bfe7fe1778b7276bef356311b57d2270e53f937f7b",
                    "confirmations": 41337,
                    "confirmed": "2014-08-29T10:29:31Z",
                    "double_spend": false
                }
            ],
            "tx_url": "https://api.blockcypher.com/v1/btc/main/txs/",
            "error": "",
            "errors": []
        }
        */

        $wallet = WalletTest::getJson();
        $txref = TXRefTest::getJson();

        return '{"wallet":' . $wallet . ',"total_received":4433416,"total_sent":0,"balance":4433416,"unconfirmed_balance":0,"final_balance":4433416,"n_tx":7,"unconfirmed_n_tx":0,"final_n_tx":7,"txrefs":[' . $txref . '],"unconfirmed_txrefs":[' . $txref . '],"tx_url":"https://api.blockcypher.com/v1/btc/main/txs/","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Address
     */
    public function testSerializationDeserialization()
    {
        $obj = new Address(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getWallet());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Address $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getWallet(), WalletTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
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
                WalletAsAddressTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("alice", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('BlockCypher\Api\Address', $result);
    }
}
<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\AddressBalance;

/**
 * Class WalletBalanceAsAddressBalanceTest
 *
 * This test case only tests AddressBalance class when it is used with a wallet instead of an address.
 *
 * @package BlockCypher\Test\Api
 */
class WalletBalanceAsAddressBalanceTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return AddressBalance
     */
    public static function getObject()
    {
        return new AddressBalance(self::getJson());
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
            "error": "",
            "errors": []
        }
        */

        $wallet = WalletTest::getJson();

        return '{"wallet":' . $wallet . ',"total_received":231765,"total_sent":182465,"balance":49300,"unconfirmed_balance":0,"final_balance":49300,"n_tx":3,"unconfirmed_n_tx":0,"final_n_tx":3,"error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return AddressBalance
     */
    public function testSerializationDeserialization()
    {
        $obj = new AddressBalance(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getWallet());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressBalance $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getWallet(), WalletTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param AddressBalance $obj
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
                WalletBalanceAsAddressBalanceTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("alice", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('BlockCypher\Api\AddressBalance', $result);
    }
}
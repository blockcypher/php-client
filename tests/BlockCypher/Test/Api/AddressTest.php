<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Address;

/**
 * Class AddressTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressTest extends ResourceModelTestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return Address
     */
    public function testSerializationDeserialization()
    {
        $obj = new Address(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getAddress());
        $this->assertNotNull($obj->getTotalReceived());
        $this->assertNotNull($obj->getTotalSent());
        $this->assertNotNull($obj->getBalance());
        $this->assertNotNull($obj->getUnconfirmedBalance());
        $this->assertNotNull($obj->getFinalBalance());
        $this->assertNotNull($obj->getNTx());
        $this->assertNotNull($obj->getUnconfirmedNTx());
        $this->assertNotNull($obj->getFinalNTx());
        $this->assertNotNull($obj->getTxrefs());
        $this->assertNotNull($obj->getUnconfirmedTxrefs());
        $this->assertNotNull($obj->getTxUrl());

        $this->assertJsonStringEqualsJsonString(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object Address
     * @return string
     */
    public static function getJson()
    {
        /*
        {
            "address": "1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD",
            "total_received": 4433416,
            "total_sent": 0,
            "balance": 4433416,
            "unconfirmed_balance": 0,
            "final_balance": 4433416,
            "n_tx": 7,
            "unconfirmed_n_tx": 0,
            "final_n_tx": 7,
            "txrefs": [
            {
              "tx_hash": "14b1052855bbf6561bc4db8aa501762e7cc1e86994dda9e782a6b73b1ce0dc1e",
              "block_height": 302013,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 20213,
              "spent": false,
              "confirmations": 50118,
              "confirmed": "2014-05-22T03:46:25Z",
              "double_spend": false
            },
            {
              "tx_hash": "4cff011ec53022f2ae47197d1a2fd4a6ac2a80139f4d0131c1fed625ed5dc869",
              "block_height": 302002,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 40596,
              "spent": false,
              "confirmations": 50129,
              "confirmed": "2014-05-22T02:56:08Z",
              "double_spend": false
            },
            {
              "tx_hash": "ea1cbb874ed4e40add51b4d65b877dc4e8d69bb63f5b2220a79d673c413b778a",
              "block_height": 302002,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 101491,
              "spent": false,
              "confirmations": 50129,
              "confirmed": "2014-05-22T02:56:08Z",
              "double_spend": false
            },
            {
              "tx_hash": "b4735a0690dab16b8789fceaf81c511f3be484e319f684cc214380eaa2851030",
              "block_height": 292601,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 3500000,
              "spent": false,
              "confirmations": 59530,
              "confirmed": "2014-03-26T17:08:04Z",
              "double_spend": false
            },
            {
              "tx_hash": "0416b8db5db4fa088437008aea7889e966e326f11c52c1da95161cd2ded95185",
              "block_height": 292519,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 100000,
              "spent": false,
              "confirmations": 59612,
              "confirmed": "2014-03-26T04:18:38Z",
              "double_spend": false
            },
            {
              "tx_hash": "995a50e05d197be88d4da74160b4bcd2c363ebb1a49f95e572667d580bc70aba",
              "block_height": 292469,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 500000,
              "spent": false,
              "confirmations": 59662,
              "confirmed": "2014-03-25T21:32:08Z",
              "double_spend": false
            },
            {
              "tx_hash": "0c83c8321537a7c79dc6214788944ba6cd5ea76f0594453b6251fcf1856f2e4b",
              "block_height": 292336,
              "tx_input_n": -1,
              "tx_output_n": 0,
              "value": 171116,
              "spent": false,
              "confirmations": 59795,
              "confirmed": "2014-03-25T00:07:31Z",
              "double_spend": false
            }
            ],
            "tx_url": "https://api.blockcypher.com/v1/btc/main/txs/",
            "error": "",
            "errors": []
        }
        */

        $txref = TXRefTest::getJson();

        return '{"address":"1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD","total_received":4433416,"total_sent":0,"balance":4433416,"unconfirmed_balance":0,"final_balance":4433416,"n_tx":7,"unconfirmed_n_tx":0,"final_n_tx":7,"txrefs":[' . $txref . '],"unconfirmed_txrefs":[' . $txref . '],"tx_url":"https://api.blockcypher.com/v1/btc/main/txs/","error":"","errors":[]}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param Address $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getAddress(), "1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD");
        $this->assertEquals($obj->getTotalReceived(), 4433416);
        $this->assertEquals($obj->getTotalSent(), 0);
        $this->assertEquals($obj->getBalance(), 4433416);
        $this->assertEquals($obj->getUnconfirmedBalance(), 0);
        $this->assertEquals($obj->getFinalBalance(), 4433416);
        $this->assertEquals($obj->getNTx(), 7);
        $this->assertEquals($obj->getUnconfirmedNTx(), 0);
        $this->assertEquals($obj->getFinalNTx(), 7);
        $this->assertEquals($obj->getTxrefs(), array(TXRefTest::getObject()));
        $this->assertEquals($obj->getUnconfirmedTxrefs(), array(TXRefTest::getObject()));
        $this->assertEquals($obj->getTxUrl(), "https://api.blockcypher.com/v1/btc/main/txs/");

        // Calculate properties
        $this->assertEquals($obj->getAllTxrefs(), array(TXRefTest::getObject(), TXRefTest::getObject()));
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     */
    public function testCreate($obj, /** @noinspection PhpDocSignatureInspection */
                               $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressKeyChainTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->create(null, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
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
                AddressTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForAddressNull($obj, /** @noinspection PhpDocSignatureInspection */
                                                          $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get(null, array(), $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForEmptyAddress($obj, /** @noinspection PhpDocSignatureInspection */
                                                           $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get('', array(), $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     */
    public function testGetWithParams($obj, /** @noinspection PhpDocSignatureInspection */
                                      $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        $params = array(
            'unspentOnly' => 'true',
            'before' => 300000,
        );

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD", $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Address $obj
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
                AddressTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     */
    public function testGetOnlyBalance($obj, /** @noinspection PhpDocSignatureInspection */
                                       $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressBalanceTest::getJson()
            ));

        $address = AddressBalanceTest::getObject();

        /** @noinspection PhpParamsInspection */
        $result = $obj->getOnlyBalance($address->getAddress(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($address, $result);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . AddressTest::getJson() . ']'
            ));

        $addressList = Array(AddressTest::getObject()->getAddress());

        $result = $obj->getMultiple($addressList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], AddressTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return Address
     */
    public static function getObject()
    {
        return new Address(self::getJson());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Address $obj
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
                '[' . AddressTest::getJson() . ']'
            ));

        $addressList = Array(AddressTest::getObject()->getAddress());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($addressList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Address $obj
     */
    public function testGetMultipleWithParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . AddressTest::getJson() . ']'
            ));

        $addressList = Array(AddressTest::getObject()->getAddress());
        $params = array(
            'unspentOnly' => 'true',
            'before' => 300000,
        );

        $result = $obj->getMultiple($addressList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], AddressTest::getObject());
    }
}
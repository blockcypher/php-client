<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Transaction;

/**
 * Class Transaction
 *
 * @package BlockCypher\Test\Api
 */
class TransactionTest extends ResourceModelTestCase
{
    // TODO:
    // - add test with hex property. Only included when the includeHex URL property is set to true.
    // - add test with receive_count property. Unconfirmed transactions only. The number of peers that have sent this transaction to us
    // - add test with includeHex URL property set to true.
    // - add test for batch queries (instart and limit URL parameters)
    // - add test for double spend case (double_spend, double_of, receive_count)
    // - add test for age property

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Transaction
     */
    public function testSerializationDeserialization()
    {
        $obj = new Transaction(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getBlockHash());
        $this->assertNotNull($obj->getBlockHeight());
        $this->assertNotNull($obj->getHash());
        $this->assertNotNull($obj->getAddresses());
        $this->assertNotNull($obj->getTotal());
        $this->assertNotNull($obj->getFees());
        // TODO: Only included when the includeHex URL property is set to true.
        //$this->assertNotNull($obj->getHex());
        $this->assertNotNull($obj->getPreference());
        $this->assertNotNull($obj->getRelayedBy());
        $this->assertNotNull($obj->getConfirmed());
        $this->assertNotNull($obj->getReceived());
        $this->assertNotNull($obj->getVer());
        $this->assertNotNull($obj->getLockTime());
        $this->assertNotNull($obj->getDoubleSpend());
        // TODO: Only present for unconfirmed transactions
        //$this->assertNotNull($obj->getReceiveCount());
        $this->assertNotNull($obj->getVinSz());
        $this->assertNotNull($obj->getVoutSz());
        $this->assertNotNull($obj->getConfirmations());
        $this->assertNotNull($obj->getConfidence());
        $this->assertNotNull($obj->getInputs());
        $this->assertNotNull($obj->getOutputs());

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
          "block_hash": "0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328",
          "block_height": 293000,
          "hash": "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449",
          "addresses": [
            "13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy",
            "19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L",
            "1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy",
            "1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq",
            "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"
          ],
          "total": 70320221545,
          "fees": 0,
          "preference": "low",
          "relayed_by": "",
          "confirmed": "2014-03-29T01:29:19Z",
          "received": "2014-03-29T01:29:19Z",
          "ver": 1,
          "lock_time": 0,
          "double_spend": false,
          "vin_sz": 4,
          "vout_sz": 1,
          "confirmations": 59116,
          "confidence": 1,
          "inputs": [
            {
              "prev_hash": "583910b7bf90ab802e22e5c25a89b59862b20c8c1aeb24dfb94e7a508a70f121",
              "output_index": 1,
              "script": "4830450220504b1ccfddf508422bdd8b0fcda2b1483e87aee1b486c0130bc29226bbce3b4e022100b5befcfcf0d3bf6ebf0ac2f93badb19e3042c7bed456c398e743b885e782466c012103b1feb40b99e8ff18469484a50e8b52cc478d5f4f773a341fbd920a4ceaedd4bf",
              "output_value": 16450000,
              "sequence": 4294967295,
              "addresses": [
                "1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq"
              ],
              "script_type": "pay-to-pubkey-hash"
            },
            {
              "prev_hash": "f6966bb3d3ba0eb97fd11b223fb13c793c0b4a1b3deb575e8ae38d666c1d00d9",
              "output_index": 36,
              "script": "48304502210086de855e03008abcc49335c775973eab9ace2e16c3bfe6536218c1d029287fdb0220129ced657870af63f61cdd4b941996f9a243d1f306e774fc9c5f3dea0af8d581012103cbe40d1d790799a6494c07f844eaf05b4c6deab0b9dee2ee45c8decead12c5cd",
              "output_value": 10061545,
              "sequence": 4294967295,
              "addresses": [
                "19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L"
              ],
              "script_type": "pay-to-pubkey-hash"
            },
            {
              "prev_hash": "9ea2f9695e6694309fb0d8b966afb4678a77a59f160822e33819fada9e0c8288",
              "output_index": 1,
              "script": "48304502201f1eb5b79279258a91c00dee09dff5d6f6ece7c01639e66a6bdd579136ecddee022100d4a9ed93183bf338e51ba80bc1dd10ff03e9e159bd8ea59db3a5c10aa0ccd3400121022667ee37e180c1ad2fef6f16aa52ed27799f629364dfe51e144dd683317dbbd2",
              "output_value": 70000000000,
              "sequence": 4294967295,
              "addresses": [
                "1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy"
              ],
              "script_type": "pay-to-pubkey-hash"
            },
            {
              "prev_hash": "279ccbbab8605390a85fe6f0e4fb04ec1946ee6033054b16fec72e1304742d5d",
              "output_index": 0,
              "script": "483045022100baac0c25867855f62592872cfac522d59fddd590a6cc290c8ad3bbe6b1151b5802204f2713c565ce6b00e5ea00e955d35e3b0878af5474feda35ebbb73232122d5480121023ed3b44ad598e3834e561efed205c221b7bc2e577e752eeaa66e85e60d0381c9",
              "output_value": 293710000,
              "sequence": 4294967295,
              "addresses": [
                "13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy"
              ],
              "script_type": "pay-to-pubkey-hash"
            }
          ],
          "outputs": [
            {
              "value": 70320221545,
              "script": "76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac",
              "spent_by": "35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee",
              "addresses": [
                "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"
              ],
              "script_type": "pay-to-pubkey-hash"
            }
          ]
        }
        */

        //return '{"block_hash":"0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328","block_height":293000,"hash":"f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449","addresses":["13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy","19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L","1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy","1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq","1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"],"total":70320221545,"fees":0,"preference":"low","relayed_by":"","confirmed":"2014-03-29T01:29:19Z","received":"2014-03-29T01:29:19Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":4,"vout_sz":1,"confirmations":59116,"confidence":1,"inputs":[{"prev_hash":"583910b7bf90ab802e22e5c25a89b59862b20c8c1aeb24dfb94e7a508a70f121","output_index":1,"script":"4830450220504b1ccfddf508422bdd8b0fcda2b1483e87aee1b486c0130bc29226bbce3b4e022100b5befcfcf0d3bf6ebf0ac2f93badb19e3042c7bed456c398e743b885e782466c012103b1feb40b99e8ff18469484a50e8b52cc478d5f4f773a341fbd920a4ceaedd4bf","output_value":16450000,"sequence":4294967295,"addresses":["1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq"],"script_type":"pay-to-pubkey-hash"},{"prev_hash":"f6966bb3d3ba0eb97fd11b223fb13c793c0b4a1b3deb575e8ae38d666c1d00d9","output_index":36,"script":"48304502210086de855e03008abcc49335c775973eab9ace2e16c3bfe6536218c1d029287fdb0220129ced657870af63f61cdd4b941996f9a243d1f306e774fc9c5f3dea0af8d581012103cbe40d1d790799a6494c07f844eaf05b4c6deab0b9dee2ee45c8decead12c5cd","output_value":10061545,"sequence":4294967295,"addresses":["19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L"],"script_type":"pay-to-pubkey-hash"},{"prev_hash":"9ea2f9695e6694309fb0d8b966afb4678a77a59f160822e33819fada9e0c8288","output_index":1,"script":"48304502201f1eb5b79279258a91c00dee09dff5d6f6ece7c01639e66a6bdd579136ecddee022100d4a9ed93183bf338e51ba80bc1dd10ff03e9e159bd8ea59db3a5c10aa0ccd3400121022667ee37e180c1ad2fef6f16aa52ed27799f629364dfe51e144dd683317dbbd2","output_value":70000000000,"sequence":4294967295,"addresses":["1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy"],"script_type":"pay-to-pubkey-hash"},{"prev_hash":"279ccbbab8605390a85fe6f0e4fb04ec1946ee6033054b16fec72e1304742d5d","output_index":0,"script":"483045022100baac0c25867855f62592872cfac522d59fddd590a6cc290c8ad3bbe6b1151b5802204f2713c565ce6b00e5ea00e955d35e3b0878af5474feda35ebbb73232122d5480121023ed3b44ad598e3834e561efed205c221b7bc2e577e752eeaa66e85e60d0381c9","output_value":293710000,"sequence":4294967295,"addresses":["13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy"],"script_type":"pay-to-pubkey-hash"}],"outputs":[{"value":70320221545,"script":"76a914e6aad9d712c419ea8febf009a3f3bfdd8d222fac88ac","spent_by":"35832d6c70b98b54e9a53ab2d51176eb19ad11bc4505d6bb1ea6c51a68cb92ee","addresses":["1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"],"script_type":"pay-to-pubkey-hash"}]}';

        /** @noinspection SpellCheckingInspection */
        return '{"block_hash":"0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328","block_height":293000,"hash":"f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449","addresses":["13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy","19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L","1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy","1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq","1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"],"total":70320221545,"fees":0,"preference":"low","relayed_by":"","confirmed":"2014-03-29T01:29:19Z","received":"2014-03-29T01:29:19Z","ver":1,"lock_time":0,"double_spend":false,"vin_sz":4,"vout_sz":1,"confirmations":59116,"confidence":1,"inputs":[' . InputTest::getJson() . '],"outputs":[' . OutputTest::getJson() . ']}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param Transaction $obj
     */
    public function testGetters($obj)
    {
        /** @noinspection SpellCheckingInspection */
        $addresses = array(
            "13XXaBufpMvqRqLkyDty1AXqueZHVe6iyy",
            "19YtzZdcfs1V2ZCgyRWo8i2wLT8ND1Tu4L",
            "1BNiazBzCxJacAKo2yL83Wq1VJ18AYzNHy",
            "1GbMfYui17L5m6sAy3L3WXAtf1P32bxJXq",
            "1N2f642sbgCMbNtXFajz9XDACDFnFzdXzV"
        );

        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getBlockHash(), "0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328");
        $this->assertEquals($obj->getBlockHeight(), "293000");
        /** @noinspection SpellCheckingInspection */
        $this->assertEquals($obj->getHash(), "f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449");
        $this->assertEquals($obj->getAddresses(), $addresses);
        $this->assertEquals($obj->getTotal(), 70320221545);
        $this->assertEquals($obj->getFees(), 0);
        // TODO: Only included when the includeHex URL property is set to true.
        //$this->assertEquals($obj->getHex(), "");
        $this->assertEquals($obj->getPreference(), "low");
        $this->assertEquals($obj->getRelayedBy(), "");
        $this->assertEquals($obj->getConfirmed(), "2014-03-29T01:29:19Z");
        $this->assertEquals($obj->getReceived(), "2014-03-29T01:29:19Z");
        $this->assertEquals($obj->getVer(), 1);
        $this->assertEquals($obj->getLockTime(), 0);
        $this->assertEquals($obj->getDoubleSpend(), false);
        // TODO: Unconfirmed transactions only. The number of peers that have sent this transaction to us
        //$this->assertEquals($obj->getReceiveCount(), 1);
        $this->assertEquals($obj->getVinSz(), 4);
        $this->assertEquals($obj->getVoutSz(), 1);
        $this->assertEquals($obj->getConfirmations(), 59116);
        $this->assertEquals($obj->getConfidence(), 1);
        $this->assertEquals($obj->getInputs(), array(InputTest::getObject()));
        $this->assertEquals($obj->getOutputs(), array(OutputTest::getObject()));
    }

    /**
     * @dataProvider mockProvider
     * @param Transaction $obj
     * @param $mockApiContext
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TransactionTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        /** @noinspection SpellCheckingInspection */
        $result = $obj->get("f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param Transaction $obj
     * @param $mockApiContext
     */
    public function testGetWithParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TransactionTest::getJson()
            ));

        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        /** @noinspection PhpParamsInspection */
        /** @noinspection SpellCheckingInspection */
        $result = $obj->get("f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449", $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Transaction $obj
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
                TransactionTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449", $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param Transaction $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TransactionTest::getJson() . ']'
            ));

        $transactionList = Array(AddressTest::getObject()->getAddress());

        $result = $obj->getMultiple($transactionList, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TransactionTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return Transaction
     */
    public static function getObject()
    {
        return new Transaction(self::getJson());
    }

    /**
     * @dataProvider mockProvider
     * @param Transaction $obj
     */
    public function testGetMultipleWithParams($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TransactionTest::getJson() . ']'
            ));

        $transactionList = Array(AddressTest::getObject()->getAddress());
        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        $result = $obj->getMultiple($transactionList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TransactionTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Transaction $obj
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
                '[' . TransactionTest::getJson() . ']'
            ));

        $transactionList = Array(AddressTest::getObject()->getAddress());

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get($transactionList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}
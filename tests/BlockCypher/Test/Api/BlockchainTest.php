<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\Blockchain;

/**
 * Class Blockchain
 *
 * @package BlockCypher\Test\Api
 */
class BlockchainTest extends ResourceModelTestCase
{
    /**
     * Gets Object Instance with Json data filled in
     * @return Blockchain
     */
    public static function getObject()
    {
        return new Blockchain(self::getJson());
    }

    /**
     * Gets Json String of Object Blockchain
     * @return string
     */
    public static function getJson()
    {
        /*
        {
          "name":"BTC.main",
          "height":361452,
          "hash":"0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862",
          "time":"2015-06-18T09:17:33.674206028Z",
          "latest_url":"https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862",
          "previous_hash":"00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806",
          "previous_url":"https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806",
          "peer_count":302,
          "unconfirmed_count":2116,
          "high_fee_per_kb":41304,
          "medium_fee_per_kb":25631,
          "low_fee_per_kb":12500,
          "last_fork_height":360322,
          "last_fork_hash":"00000000000000000f8d0292d70f3d28237a5610c39446a447c8907a50dbf75d"
        }
        */

        return '{"name":"BTC.main","height":361452,"hash":"0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862","time":"2015-06-18T09:17:33.674206028Z","latest_url":"https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862","previous_hash":"00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806","previous_url":"https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806","peer_count":302,"unconfirmed_count":2116,"high_fee_per_kb":41304,"medium_fee_per_kb":25631,"low_fee_per_kb":12500,"last_fork_height":360322,"last_fork_hash":"00000000000000000f8d0292d70f3d28237a5610c39446a447c8907a50dbf75d","error":"","errors":[]}';
    }

    /**
     * Tests for Serialization and Deserialization Issues
     * @return Blockchain
     */
    public function testSerializationDeserialization()
    {
        $obj = new Blockchain(self::getJson());

        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getHeight());
        $this->assertNotNull($obj->getHash());
        $this->assertNotNull($obj->getTime());
        $this->assertNotNull($obj->getLatestUrl());
        $this->assertNotNull($obj->getPreviousHash());
        $this->assertNotNull($obj->getPreviousUrl());
        $this->assertNotNull($obj->getPeerCount());
        $this->assertNotNull($obj->getUnconfirmedCount());
        $this->assertNotNull($obj->getHighFeePerKb());
        $this->assertNotNull($obj->getMediumFeePerKb());
        $this->assertNotNull($obj->getLowFeePerKb());
        $this->assertNotNull($obj->getLastForkHeight());
        $this->assertNotNull($obj->getLastForkHash());

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param Blockchain $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getName(), "BTC.main");
        $this->assertEquals($obj->getHeight(), 361452);
        $this->assertEquals($obj->getHash(), "0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862");
        $this->assertEquals($obj->getTime(), "2015-06-18T09:17:33.674206028Z");
        $this->assertEquals($obj->getLatestUrl(), "https://api.blockcypher.com/v1/btc/main/blocks/0000000000000000110740bc53a7caf67e1c5761eb883360af2c9f27b7ca4862");
        $this->assertEquals($obj->getPreviousHash(), "00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806");
        $this->assertEquals($obj->getPreviousUrl(), "https://api.blockcypher.com/v1/btc/main/blocks/00000000000000000fee58c66e4481ed836b9ea182a84adf39b70e110a21d806");
        $this->assertEquals($obj->getPeerCount(), 302);
        $this->assertEquals($obj->getUnconfirmedCount(), 2116);
        $this->assertEquals($obj->getHighFeePerKb(), 41304);
        $this->assertEquals($obj->getMediumFeePerKb(), 25631);
        $this->assertEquals($obj->getLowFeePerKb(), 12500);
        $this->assertEquals($obj->getLastForkHeight(), 360322);
        $this->assertEquals($obj->getLastForkHash(), "00000000000000000f8d0292d70f3d28237a5610c39446a447c8907a50dbf75d");
    }

    /**
     * @dataProvider mockProvider
     * @param Blockchain $obj
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                BlockchainTest::getJson()
            ));

        $result = $obj->get("BTC.main", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param Blockchain $obj
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
                BlockchainTest::getJson()
            ));

        /** @noinspection PhpUndefinedVariableInspection */
        /** @noinspection PhpParamsInspection */
        $obj->get("BTC.main", $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}

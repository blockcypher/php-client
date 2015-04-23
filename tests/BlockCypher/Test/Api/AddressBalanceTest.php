<?php

namespace BlockCypher\Test\Api;

use BlockCypher\Api\AddressBalance;

/**
 * Class AddressBalanceTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressBalanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests for Serialization and Deserialization Issues
     * @return AddressBalance
     */
    public function testSerializationDeserialization()
    {
        $obj = new AddressBalance(self::getJson());

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

        $this->assertEquals(self::getJson(), $obj->toJson());

        return $obj;
    }

    /**
     * Gets Json String of Object AddressBalance
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
          "final_n_tx": 7
        }
        */

        return '{"address":"1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD","total_received":4433416,"total_sent":0,"balance":4433416,"unconfirmed_balance":0,"final_balance":4433416,"n_tx":7,"unconfirmed_n_tx":0,"final_n_tx":7}';
    }

    /**
     * @depends testSerializationDeserialization
     * @param AddressBalance $obj
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
                AddressBalanceTest::getJson()
            ));

        /** @noinspection PhpParamsInspection */
        $result = $obj->get("1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD", array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressBalance $obj
     */
    public function testGetMultiple($obj, $mockApiContext)
    {
        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . AddressBalanceTest::getJson() . ']'
            ));

        $addressBalanceList = Array(AddressBalanceTest::getObject()->getAddress());

        $result = $obj->getMultiple($addressBalanceList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], AddressBalanceTest::getObject());
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return AddressBalance
     */
    public static function getObject()
    {
        return new AddressBalance(self::getJson());
    }

    public function mockProvider()
    {
        $obj = self::getObject();

        $mockApiContext = $this->getMockBuilder('\BlockCypher\Rest\ApiContext')
            ->disableOriginalConstructor()
            ->setMethods(array('getBaseChainUrl'))
            ->getMock();

        $mockApiContext->expects($this->once())
            ->method('getBaseChainUrl')
            ->will($this->returnValue('/v1/btc/main'));

        return array(
            array($obj, $mockApiContext),
            array($obj, null)
        );
    }
}
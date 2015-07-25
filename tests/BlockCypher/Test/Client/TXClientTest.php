<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\AddressTest;
use BlockCypher\Test\Api\TXConfidenceTest;
use BlockCypher\Test\Api\TXSkeletonTest;
use BlockCypher\Test\Api\TXTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class TXClientTest
 *
 * @package BlockCypher\Test\Client
 */
class TXClientTest extends ClientTestCase
{
    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGet($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXTest::getJson()
            ));

        $result = $obj->get(TXTest::getObject()->getHash(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXTest::getJson()
            ));

        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        $result = $obj->get(TXTest::getObject()->getHash(), $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXTest::getJson()
            ));

        $obj->get(TXTest::getObject()->getHash(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultiple($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXTest::getJson() . ']'
            ));

        $transactionList = Array(TXTest::getObject()->getHash());

        $result = $obj->getMultiple($transactionList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TXTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetUnconfirmed($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXTest::getJson() . ']'
            ));

        $result = $obj->getUnconfirmed(array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TXTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testDecode($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXTest::getJson()
            ));

        $result = $obj->decode(TXTest::getObject()->getHex(), array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        $this->assertEquals($result, TXTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testPush($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXTest::getJson()
            ));

        $result = $obj->decode(TXTest::getObject()->getHex(), array(), $mockApiContext, $mockBlockCypherRestCall);

        $this->assertNotNull($result);
        $this->assertEquals($result, TXTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXTest::getJson() . ']'
            ));

        $transactionList = Array(AddressTest::getObject()->getAddress());
        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        $result = $obj->getMultiple($transactionList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TXTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXTest::getJson() . ']'
            ));

        $transactionList = Array(AddressTest::getObject()->getAddress());

        $obj->get($transactionList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXSkeletonTest::getJson()
            ));

        $result = $obj->create(TXTest::getObject(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\TXSkeleton', $result);
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testSend($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXSkeletonTest::getJson()
            ));

        $result = $obj->send(TXSkeletonTest::getObject(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    public function testSign()
    {
        $obj = static::getObject();

        $mockApiContext = $this->getMockBuilder('\BlockCypher\Rest\ApiContext')
            ->disableOriginalConstructor()
            ->setMethods(array('getBaseChainUrl', 'getCoinSymbol'))
            ->getMock();

        $mockApiContext->expects($this->any())
            ->method('getBaseChainUrl')
            ->will($this->returnValue("/v1/btc/test"));

        $mockApiContext->expects($this->once())
            ->method('getCoinSymbol')
            ->will($this->returnValue("btc-testnet"));

        $mockBlockCypherRestCall = $this->getMockBuilder('\BlockCypher\Transport\BlockCypherRestCall')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXSkeletonTest::getJson()
            ));

        $hexPrivateKey = "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e";
        $expectedPubkeys = array("0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf");
        $expectedSignatures = array("30450221008627dbea1b070e8ceb025ab0ecb154227a65a34e6e8cd64966f181ca151d354f022066264b1930ad9e638f2853db683f5f81059e8c547bf9b4512046d2525c170c0b");

        /** @noinspection PhpParamsInspection */
        $result = $obj->sign(TXSkeletonTest::getObject(), $hexPrivateKey, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($expectedSignatures, $result->getSignatures());
        $this->assertEquals($expectedPubkeys, $result->getPubkeys());
    }

    /**
     * @return TXClient
     */
    public static function getObject()
    {
        return new TXClient();
    }

    // TXConfidence

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetConfidence($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXConfidenceTest::getJson()
            ));

        $result = $obj->getConfidence(TXConfidenceTest::getObject()->getTxhash(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetConfidenceParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                TXConfidenceTest::getJson()
            ));

        $obj->getConfidence(TXConfidenceTest::getObject()->getTxhash(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleConfidences($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXConfidenceTest::getJson() . ']'
            ));

        $txConfidenceList = Array(TXConfidenceTest::getObject()->getTxhash());

        $result = $obj->getMultipleConfidences($txConfidenceList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], TXConfidenceTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param TXClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleConfidenceParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . TXConfidenceTest::getJson() . ']'
            ));

        $txConfidenceList = Array(TXConfidenceTest::getObject()->getTxhash());

        $obj->getMultipleConfidences($txConfidenceList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}
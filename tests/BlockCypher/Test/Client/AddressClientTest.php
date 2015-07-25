<?php

namespace BlockCypher\Test\Client;

use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Test\Api\AddressBalanceTest;
use BlockCypher\Test\Api\AddressKeyChainTest;
use BlockCypher\Test\Api\AddressTest;
use BlockCypher\Test\Api\FullAddressTest;
use BlockCypher\Transport\BlockCypherRestCall;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class AddressClientTest
 *
 * @package BlockCypher\Test\Client
 */
class AddressClientTest extends ClientTestCase
{
    /**
     * @return AddressClient
     */
    public static function getObject()
    {
        return new AddressClient();
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGenerateAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressKeyChainTest::getJson()
            ));

        $result = $obj->generateAddress($mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGenerateMultisigAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressKeyChainTest::getJson()
            ));

        $pubkeys = AddressKeyChainTest::getObject()->getPubkeys();
        $scriptType = AddressKeyChainTest::getObject()->getScriptType();

        $result = $obj->generateMultisigAddress($pubkeys, $scriptType, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @expectedException \InvalidArgumentException
     */
    public function testGenerateMultisigAddressValidationForPubkeys($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressKeyChainTest::getJson()
            ));

        $pubkeys = 'NOT ARRAY';
        $scriptType = AddressKeyChainTest::getObject()->getScriptType();

        $result = $obj->generateMultisigAddress($pubkeys, $scriptType, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testCreate($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressKeyChainTest::getJson()
            ));

        $result = $obj->create(null, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGet($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        $result = $obj->get(AddressTest::getObject()->getAddress(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForAddressNull($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        $obj->get(null, array(), $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @expectedException \InvalidArgumentException
     */
    public function testGetParamsValidationForEmptyAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        $obj->get('', array(), $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressTest::getJson()
            ));

        $params = array(
            'unspentOnly' => 'true',
            'before' => 300000,
        );

        $result = $obj->get(AddressTest::getObject()->getAddress(), $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
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
                AddressTest::getJson()
            ));

        $obj->get(AddressTest::getObject()->getAddress(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetOnlyBalance($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressBalanceTest::getJson()
            ));

        $address = AddressBalanceTest::getObject();

        $result = $obj->getBalance($address->getAddress(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($address, $result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultiple($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
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
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
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
                '[' . AddressTest::getJson() . ']'
            ));

        $addressList = Array(AddressTest::getObject()->getAddress());

        $obj->get($addressList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
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

    // Address Balance

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetBalance($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressBalanceTest::getJson()
            ));

        $result = $obj->getBalance(AddressBalanceTest::getObject()->getAddress(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('BlockCypher\Api\AddressBalance', $result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetBalanceParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                AddressBalanceTest::getJson()
            ));

        $obj->getBalance(AddressBalanceTest::getObject()->getAddress(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleBalances($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . AddressBalanceTest::getJson() . ']'
            ));

        $addressBalanceList = Array(AddressBalanceTest::getObject()->getAddress());

        $result = $obj->getMultipleBalances($addressBalanceList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], AddressBalanceTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleBalancesParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . AddressBalanceTest::getJson() . ']'
            ));

        $addressBalanceList = Array(AddressBalanceTest::getObject()->getAddress());

        $obj->getMultipleBalances($addressBalanceList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    // Full Address

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetFullAddress($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FullAddressTest::getJson()
            ));

        $result = $obj->getFullAddress(FullAddressTest::getObject()->getAddress(), array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetFullAddressWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FullAddressTest::getJson()
            ));

        $params = array(
            'unspentOnly' => 'true',
            'before' => 300000,
        );

        $result = $obj->getFullAddress(FullAddressTest::getObject()->getAddress(), $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetFullAddressParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                FullAddressTest::getJson()
            ));

        $obj->getFullAddress(FullAddressTest::getObject()->getAddress(), $params, $mockApiContext, $mockBlockCypherRestCall);
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleFullAddresses($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . FullAddressTest::getJson() . ']'
            ));

        $fullAddressList = Array(FullAddressTest::getObject()->getAddress());

        $result = $obj->getMultipleFullAddresses($fullAddressList, array(), $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], FullAddressTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     */
    public function testGetMultipleFullAddressesWithParams($obj, $mockApiContext, $mockBlockCypherRestCall)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . FullAddressTest::getJson() . ']'
            ));

        $fullAddressList = Array(FullAddressTest::getObject()->getAddress());
        $params = array(
            'unspentOnly' => 'true',
            'before' => 300000,
        );

        $result = $obj->getMultipleFullAddresses($fullAddressList, $params, $mockApiContext, $mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($result[0], FullAddressTest::getObject());
    }

    /**
     * @dataProvider mockProviderGetParamsValidation
     * @param AddressClient $obj
     * @param PHPUnit_Framework_MockObject_MockObject|ApiContext $mockApiContext
     * @param PHPUnit_Framework_MockObject_MockObject|BlockCypherRestCall $mockBlockCypherRestCall
     * @param $params
     * @expectedException \InvalidArgumentException
     */
    public function testGetMultipleFullAddressesParamsValidationForParams($obj, $mockApiContext, $mockBlockCypherRestCall, $params)
    {
        $mockBlockCypherRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                '[' . FullAddressTest::getJson() . ']'
            ));

        $fullAddressList = Array(FullAddressTest::getObject()->getAddress());

        $obj->getMultipleFullAddresses($fullAddressList, $params, $mockApiContext, $mockBlockCypherRestCall);
    }
}
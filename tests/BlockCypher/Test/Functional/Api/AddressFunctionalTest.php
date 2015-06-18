<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Address;
use BlockCypher\Api\AddressBalance;
use BlockCypher\Api\AddressKeyChain;
use BlockCypher\Api\FullAddress;
use BlockCypher\Exception\BlockCypherConnectionException;
use BlockCypher\Test\Functional\Setup;

/**
 * Class AddressFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public $operation;

    public $response;

    public $mockBlockCypherRestCall;

    public $apiContext;

    public function setUp()
    {
        $className = $this->getClassName();
        $testName = $this->getName();
        $operationString = file_get_contents(__DIR__ . "/../resources/$className/$testName.json");
        $this->operation = Setup::jsonDecode($operationString);
        $this->response = true;
        if (array_key_exists('body', $this->operation['response'])) {
            $this->response = json_encode($this->operation['response']['body']);
        }
        Setup::SetUpForFunctionalTests($this);
    }

    /**
     * Returns just the classname of the test you are executing. It removes the namespaces.
     * @return string
     */
    public function getClassName()
    {
        return join('', array_slice(explode('\\', get_class($this)), -1));
    }

    /**
     * @return AddressKeyChain|null
     */
    public function testCreate()
    {
        //$request = $this->operation['request']['body'];
        //$addressCreateResponse = new AddressKeyChain($request);
        $result = null;
        try {
            $result = Address::create(null, $this->apiContext, $this->mockBlockCypherRestCall);
        } catch (BlockCypherConnectionException $ex) {
            $this->fail($ex->getMessage());
        }
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\AddressKeyChain', $result);
        return $result;
    }

    /**
     * @return Address
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $address = new Address($request);

        $result = Address::get($address->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Address', $result);
        // Assert only immutable values.
        $this->assertEquals($address->getAddress(), $result->getAddress());
        $this->assertEquals($address->getTxUrl(), $result->getTxUrl());
        $addressTxrefs = $address->getTxrefs();
        $resultTxrefs = $result->getTxrefs();
        $this->assertEquals($addressTxrefs[0]->getTxHash(), $resultTxrefs[0]->getTxHash());
        return $result;
    }

    /**
     * @return FullAddress
     */
    public function testGetFullAddress()
    {
        $request = $this->operation['response']['body'];
        $fullAddress = new FullAddress($request);

        $result = Address::getFullAddress($fullAddress->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\FullAddress', $result);
        // Assert only immutable values.
        $this->assertEquals($fullAddress->getAddress(), $result->getAddress());
        $this->assertEquals($fullAddress->getTxUrl(), $result->getTxUrl());
        $this->assertEquals(count($fullAddress->getTxs()), count($result->getTxs()));
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\TX', $result->getTxs());
        return $result;
    }

    /**
     * @return Address[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $addressArray = Address::getList($request);

        $addressList = array();
        /** @var Address $address */
        foreach ($addressArray as $address) {
            $addressList[] = $address->getAddress();
        }

        $result = Address::getMultiple($addressList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\Address', $result);
        $this->assertEquals(count($result), count($addressList));
        foreach ($result as $addr) {
            $this->assertContains($addr->getAddress(), $addressList);
        }
        return $result;
    }

    /**
     * @return AddressBalance
     */
    public function testGetOnlyBalance()
    {
        $request = $this->operation['response']['body'];
        $addressBalance = new AddressBalance($request);

        $result = Address::getOnlyBalance($addressBalance->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\AddressBalance', $result);
        // Assert only immutable values.
        $this->assertEquals($addressBalance->getAddress(), $result->getAddress());
        return $result;
    }

    /**
     * @return Address
     */
    public function testGetWithPaging()
    {
        $request = $this->operation['response']['body'];
        $address = new Address($request);

        $params = array(
            'before' => 300000,
        );

        $result = Address::get($address->getAddress(), $params, $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Address', $result);
        // Assert only immutable values.
        $this->assertEquals($address->getAddress(), $result->getAddress());
        $this->assertEquals($address->getTxUrl(), $result->getTxUrl());
        $this->assertEquals(count($address->getTxrefs()), count($result->getTxrefs()));

        return $result;
    }

    /**
     * @return Address
     */
    public function testGetWithUnspentOnly()
    {
        $request = $this->operation['response']['body'];
        $address = new Address($request);

        $params = array(
            'unspentOnly' => 'true', // NOTICE: string type not boolean
        );

        $result = Address::get($address->getAddress(), $params, $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Address', $result);
        // Assert only immutable values.
        $this->assertEquals($address->getAddress(), $result->getAddress());
        $this->assertEquals($address->getTxUrl(), $result->getTxUrl());
        $this->assertEquals(count($address->getTxrefs()), count($result->getTxrefs()));
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\Txref', $result->getTxrefs());
        return $result;
    }
}

<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\TX;
use BlockCypher\Test\Functional\Setup;

/**
 * Class TXFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class TXFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return TX
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $transaction = new TX($request);

        $result = TX::get($transaction->getHash(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\TX', $result);
        // Assert only immutable values.
        $this->assertEquals($transaction->getHash(), $result->getHash());
        $this->assertEquals($transaction->getAddresses(), $result->getAddresses());
        $transactionInputs = $transaction->getInputs();
        $resultInputs = $result->getInputs();
        $this->assertEquals($transactionInputs[0]->getPrevHash(), $resultInputs[0]->getPrevHash());
        return $result;
    }

    /**
     * @return TX[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $transactionArray = TX::getList($request);

        $transactionList = array();
        /** @var TX $transaction */
        foreach ($transactionArray as $transaction) {
            $transactionList[] = $transaction->getHash();
        }

        $result = TX::getMultiple($transactionList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\TX', $result);
        $this->assertEquals(count($result), count($transactionList));
        foreach ($result as $tx) {
            $this->assertContains($tx->getHash(), $transactionList);
        }
        return $result;
    }

    /**
     * @return TX
     */
    public function testGetWithPaging()
    {
        $request = $this->operation['response']['body'];
        $transaction = new TX($request);

        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        $result = TX::get($transaction->getHash(), $params, $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\TX', $result);
        // Assert only immutable values.
        $this->assertEquals($transaction->getHash(), $result->getHash());
        $this->assertEquals($transaction->getAddresses(), $result->getAddresses());
        $transactionInputs = $transaction->getInputs();
        $resultInputs = $result->getInputs();
        $this->assertEquals($transactionInputs[0]->getPrevHash(), $resultInputs[0]->getPrevHash());
        return $result;
    }
}

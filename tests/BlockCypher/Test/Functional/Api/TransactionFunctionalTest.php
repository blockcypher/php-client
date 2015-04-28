<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Transaction;
use BlockCypher\Test\Functional\Setup;

/**
 * Class TransactionFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class TransactionFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return Transaction
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $transaction = new Transaction($request);

        $result = Transaction::get($transaction->getHash(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Transaction', $result);
        // Assert only immutable values.
        $this->assertEquals($transaction->getHash(), $result->getHash());
        $this->assertEquals($transaction->getAddresses(), $result->getAddresses());
        $this->assertEquals($transaction->getInputs()[0]->getPrevHash(), $result->getInputs()[0]->getPrevHash());
        return $result;
    }

    /**
     * @return Transaction[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $transactionArray = Transaction::getList($request);

        $transactionList = array();
        /** @var Transaction $transaction */
        foreach ($transactionArray as $transaction) {
            $transactionList[] = $transaction->getHash();
        }

        $result = Transaction::getMultiple($transactionList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\Transaction', $result);
        $this->assertEquals(count($result), count($transactionList));
        foreach ($result as $tx) {
            $this->assertContains($tx->getHash(), $transactionList);
        }
        return $result;
    }

    /**
     * @return Transaction
     */
    public function testGetWithPaging()
    {
        $request = $this->operation['response']['body'];
        $transaction = new Transaction($request);

        $params = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );

        $result = Transaction::get($transaction->getHash(), $params, $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Transaction', $result);
        // Assert only immutable values.
        $this->assertEquals($transaction->getHash(), $result->getHash());
        $this->assertEquals($transaction->getAddresses(), $result->getAddresses());
        $this->assertEquals($transaction->getInputs()[0]->getPrevHash(), $result->getInputs()[0]->getPrevHash());
        return $result;
    }
}

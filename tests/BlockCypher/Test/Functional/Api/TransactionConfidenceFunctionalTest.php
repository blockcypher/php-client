<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\TransactionConfidence;
use BlockCypher\Test\Functional\Setup;

/**
 * Class TransactionConfidenceFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class TransactionConfidenceFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return TransactionConfidence
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $txConfidence = new TransactionConfidence($request);

        $result = TransactionConfidence::get($txConfidence->getTxhash(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\TransactionConfidence', $result);
        // Assert only immutable values.
        $this->assertEquals($txConfidence->getTxhash(), $result->getTxhash());
        return $result;
    }

    /**
     * @return TransactionConfidence[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $txConfidenceArray = TransactionConfidence::getList($request);

        $txConfidenceList = array();
        /** @var TransactionConfidence $txConfidence */
        foreach ($txConfidenceArray as $txConfidence) {
            $txConfidenceList[] = $txConfidence->getTxhash();
        }

        $result = TransactionConfidence::getMultiple($txConfidenceList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\TransactionConfidence', $result);
        $this->assertEquals(count($result), count($txConfidenceList));
        foreach ($result as $resultTxConfidence) {
            $this->assertContains($resultTxConfidence->getTxhash(), $txConfidenceList);
        }
        return $result;
    }
}

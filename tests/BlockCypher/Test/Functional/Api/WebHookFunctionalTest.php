<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\WebHook;
use BlockCypher\Exception\BlockCypherConnectionException;
use BlockCypher\Test\Functional\Setup;

/**
 * Class WebHookFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class WebHookFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return WebHook
     */
    public function testCreate()
    {
        $request = $this->operation['request']['body'];
        $obj = new WebHook($request);
        // Adding a random url request to make it unique
        $obj->setUrl($obj->getUrl() . '?rand=' . uniqid());
        $result = null;
        try {
            $result = $obj->create($this->apiContext, $this->mockBlockCypherRestCall);
        } catch (BlockCypherConnectionException $ex) {
            $this->fail($ex->getMessage());
        }
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\WebHook', $result);
        return $result;
    }

    /**
     * @return WebHook
     */
    /*public function testGet()
    {
        $request = $this->operation['response']['body'];
        $webHook = new WebHook($request);

        $result = WebHook::get($webHook->getId(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\WebHook', $result);
        $this->assertEquals($webHook->getId(), $result->getId());
        $this->assertEquals($webHook->getEvent(), $result->getEvent());
        return $result;
    }*/

    /**
     * @depends testCreate
     * @param $webHook WebHook
     * @return WebHook
     */
    public function testGet($webHook)
    {
        $result = WebHook::get($webHook->getId(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertWebHooksAreEquivalent($webHook, $result);
        return $result;
    }

    /**
     * Assert two WebHooks are equivalent. It compares only immutable properties.
     * @param WebHook $webHook1
     * @param WebHook $webHook2
     */
    private function assertWebHooksAreEquivalent($webHook1, $webHook2)
    {
        //$this->assertEquals($webHook1->getId(), $webHook2->getId());
        $this->assertEquals($webHook1->getEvent(), $webHook2->getEvent());
        $this->assertEquals($webHook1->getHash(), $webHook2->getHash());
        $this->assertEquals($webHook1->getWalletName(), $webHook2->getWalletName());
        $this->assertEquals($webHook1->getToken(), $webHook2->getToken());
        $this->assertEquals($webHook1->getAddress(), $webHook2->getAddress());
        $this->assertEquals($webHook1->getScript(), $webHook2->getScript());
        $this->assertEquals($webHook1->getUrl(), $webHook2->getUrl());
        //$this->assertEquals($webHook1->getErrors(), $webHook2->getErrors());
        $this->assertEquals($webHook1->getFilter(), $webHook2->getFilter());
    }

    /**
     * @depends testGet
     * @param $webHook WebHook
     * @return WebHook[]
     */
    public function testGetMultiple($webHook)
    {
        $webHookList = array(
            $webHook->getId(),
            $webHook->getId()
        );
        $result = WebHook::getMultiple($webHookList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $found = false;
        $foundObject = null;
        foreach ($result as $webHookObject) {
            if ($webHookObject->getId() == $webHook->getId()) {
                $found = true;
                $foundObject = $webHookObject;
                break;
            }
        }
        $this->assertTrue($found, "The Created WebHook was not found in the get list");
        $this->assertEquals($webHook->getId(), $foundObject->getId());
        return $result;
    }

    /**
     * @depends testGet
     * @param $webHook WebHook
     * @return WebHook[]
     */
    public function testGetAll($webHook)
    {
        $result = WebHook::getAll(array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $found = false;
        $foundObject = null;
        foreach ($result as $webHookObject) {
            if ($webHookObject->getId() == $webHook->getId()) {
                $found = true;
                $foundObject = $webHookObject;
                break;
            }
        }
        $this->assertTrue($found, "The Created WebHook was not found in the get list");
        $this->assertEquals($webHook->getId(), $foundObject->getId());
        return $result;
    }

    /**
     * @depends testGet
     * @param $webHook WebHook
     */
    public function testDelete($webHook)
    {
        $result = $webHook->delete($this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertTrue($result);
    }
}

<?php

use BlockCypher\Rest\ApiContext;

/**
 * Test class for ApiContextTest.
 *
 */
class ApiContextTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ApiContext
     */
    public $apiContext;

    public function setUp()
    {
        $this->apiContext = new ApiContext();
    }

    public function testGetRequestId()
    {
        $requestId = $this->apiContext->getrequestId();
        $this->assertNotNull($requestId);
        $this->assertEquals($requestId, $this->apiContext->getrequestId());
    }

    public function testResetRequestId()
    {
        $requestId = $this->apiContext->getrequestId();
        $newRequestId = $this->apiContext->resetRequestId();
        $this->assertNotNull($newRequestId);
        $this->assertNotEquals($newRequestId, $requestId);
    }

}

<?php

use BlockCypher\Core\BlockCypherCredentialManager;

/**
 * Test class for BlockCypherCredentialManager.
 *
 * @runTestsInSeparateProcesses
 */
class BlockCypherCredentialManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BlockCypherCredentialManager
     */
    protected $object;

    private $config = array(
        'acct1.AccessToken' => 'access-token',
        'http.ConnectionTimeOut' => '30',
        'http.Retry' => '5',
        'log.FileName' => 'BlockCypher.log',
        'log.LogLevel' => 'INFO',
        'log.LogEnabled' => '1',
    );

    /**
     * @test
     */
    public function testGetInstance()
    {
        $instance = $this->object->getInstance($this->config);
        $this->assertTrue($instance instanceof BlockCypherCredentialManager);
    }

    /**
     * @test
     */
    public function testGetSpecificCredentialObject()
    {
        $cred = $this->object->getCredentialObject('acct1');
        $this->assertNotNull($cred);
        $this->assertAttributeEquals('access-token', 'accessToken', $cred);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \BlockCypher\Exception\BlockCypherInvalidCredentialException
     */
    public function testSetCredentialObject()
    {
        $authObject = $this->getMockBuilder('\BlockCypher\Auth\SimpleTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject)->getCredentialObject();

        $this->assertNotNull($cred);
        $this->assertSame($this->object->getCredentialObject(), $authObject);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \BlockCypher\Exception\BlockCypherInvalidCredentialException
     */
    public function testSetCredentialObjectWithUserId()
    {
        $authObject = $this->getMockBuilder('\BlockCypher\Auth\SimpleTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject, 'sample')->getCredentialObject('sample');
        $this->assertNotNull($cred);
        $this->assertSame($this->object->getCredentialObject(), $authObject);
    }

    /**
     * @after testGetDefaultCredentialObject
     *
     * @throws \BlockCypher\Exception\BlockCypherInvalidCredentialException
     */
    public function testSetCredentialObjectWithoutDefault()
    {
        $authObject = $this->getMockBuilder('\BlockCypher\Auth\SimpleTokenCredential')
            ->disableOriginalConstructor()
            ->getMock();
        $cred = $this->object->setCredentialObject($authObject, null, false)->getCredentialObject();
        $this->assertNotNull($cred);
        $this->assertNotSame($this->object->getCredentialObject(), $authObject);
    }

    /**
     * @test
     */
    public function testGetInvalidCredentialObject()
    {
        $this->setExpectedException('BlockCypher\Exception\BlockCypherInvalidCredentialException');
        $this->object->getCredentialObject('invalid_biz_api1.gmail.com');
    }

    /**
     *
     */
    public function testGetDefaultCredentialObject()
    {
        $cred = $this->object->getCredentialObject();
        $this->assertNotNull($cred);
        $this->assertAttributeEquals('access-token', 'accessToken', $cred);
    }

    /**
     * @test
     */
    public function testGetRestCredentialObject()
    {
        $cred = $this->object->getCredentialObject('acct1');

        $this->assertNotNull($cred);

        $this->assertAttributeEquals($this->config['acct1.AccessToken'], 'accessToken', $cred);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = BlockCypherCredentialManager::getInstance($this->config);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}

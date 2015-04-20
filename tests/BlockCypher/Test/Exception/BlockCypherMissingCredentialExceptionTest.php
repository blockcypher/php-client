<?php
use BlockCypher\Exception\BlockCypherMissingCredentialException;

/**
 * Test class for BlockCypherMissingCredentialException.
 *
 */
class BlockCypherMissingCredentialExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BlockCypherMissingCredentialException
     */
    protected $object;

    /**
     * @test
     */
    public function testErrorMessage()
    {
        $msg = $this->object->errorMessage();
        $this->assertContains('Error on line', $msg);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new BlockCypherMissingCredentialException;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}

?>

<?php

namespace sample\Test\Functional;

/**
 * Class WalletSamplesTest
 * @package sample\Test\Functional\wallet
 */
class WalletSampleTestCase extends WebTestCase
{
    /**
     * @var string
     */
    protected static $walletName;

    /**
     * @var string
     */
    protected static $walletSamplesBaseUrl;

    public function setUp()
    {
        parent::SetUp();
        self::$walletName = 'alice_test';
        self::$walletSamplesBaseUrl = self::baseUrl() . basename(__DIR__) . '/';
    }

    /**
     * Returns just the classname of the test you are executing. It removes the namespaces.
     * @return string
     */
    public function getClassName()
    {
        return join('', array_slice(explode('\\', get_class($this)), -1));
    }

    protected function loadAndAssertSample($url)
    {
        $this->client->request('GET', $url);

        $status = $this->client->getResponse()->getStatus();
        $responseBody = (string)$this->client->getResponse()->getContent();

        $this->assertSampleIsNotBroken($status, $responseBody);
    }

    /**
     * @param string $status
     * @param string $responseBody
     */
    protected function assertSampleIsNotBroken($status, $responseBody)
    {
        $this->assertEquals(200, $status);
        $this->assertNotContainsPhpErrors($responseBody);
    }
}
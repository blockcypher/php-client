<?php

namespace sample\Test\Functional\wallet;

use BlockCypher\Api\Wallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;
use sample\Test\Functional\WalletSampleTestCase;

/**
 * Class CreateWalletEndpointTest
 * @package sample\Test\Functional\wallet
 */
class CreateWalletEndpointTest extends WalletSampleTestCase
{
    public function setUp()
    {
        parent::SetUp();
        self::$walletName = 'alice';
        $className = $this->getClassName();
        $sampleName = substr($className, 0, -4);
        $this->url = self::baseUrl() . basename(__DIR__) . '/' . $sampleName . '.php';

        $apiContext = ApiContext::create(
            'main', 'btc', 'v1',
            new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
            array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
        );

        $this->deleteWalletIfExists('alice', $apiContext);
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
     * @param $apiContext
     */
    private function deleteWalletIfExists($walletName, $apiContext)
    {
        // Delete wallet if exists
        try {
            $wallet = Wallet::get($walletName, array(), $apiContext);
            $wallet->delete(array(), $apiContext);
        } catch (\Exception $ex) {
        }
    }

    public function testCreateWalletEndpoint()
    {
        $this->loadAndAssertSample($this->url . '?wallet_name=' . self::$walletName);
    }
}
<?php

// Run on console:
// php -f .\sample\wallet-api\DeleteWalletEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Wallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$wallet = Wallet::get('alice', array(), $apiContext);
$result = $wallet->delete(array(), $apiContext);

ResultPrinter::printResult("Delete Wallet Endpoint", "Wallet", 'alice', null, $result);
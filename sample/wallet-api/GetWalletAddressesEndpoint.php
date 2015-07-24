<?php

// Run on console:
// php -f .\sample\wallet-api\GetWalletAddressesEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\WalletClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$walletClient = new WalletClient($apiContext);
$addressList = $walletClient->getWalletAddresses('alice');

ResultPrinter::printResult("Wallet Wallet Addresses endpoint", "AddressList", 'alice', null, $addressList);
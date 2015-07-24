<?php

// Run on console:
// php -f .\sample\wallet-api\CreateHDWalletEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\HDWallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\HDWalletClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$wallet = new HDWallet();
$wallet->setName('bob');
$wallet->setExtendedPublicKey('xpub661MyMwAqRbcFtXgS5sYJABqqG9YLmC4Q1Rdap9gSE8NqtwybGhePY2gZ29ESFjqJoCu1Rupje8YtGqsefD265TMg7usUDFdp6W1EGMcet8');
$wallet->setSubchainIndexes(array(1, 3));

/// For Sample Purposes Only.
$request = clone $wallet;

$walletClient = new HDWalletClient($apiContext);
$createdWallet = $walletClient->create($wallet);

ResultPrinter::printResult("Created HDWallet", "HDWallet", $createdWallet->getName(), $request, $createdWallet);
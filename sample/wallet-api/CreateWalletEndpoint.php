<?php

// Run on console:
// php -f .\sample\wallet-api\CreateWalletEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Wallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\WalletClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

// Create a new instance of Wallet object
$wallet = new Wallet();
$wallet->setName('alice');
$wallet->setAddresses(array(
    "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
));

// For Sample Purposes Only.
$request = clone $wallet;

$walletClient = new WalletClient($apiContext);
$createdWallet = $walletClient->create($wallet);

ResultPrinter::printResult("Created Wallet End Point", "Wallet", $createdWallet->getName(), $request, $createdWallet);

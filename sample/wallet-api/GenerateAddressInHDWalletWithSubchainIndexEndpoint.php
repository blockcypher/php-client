<?php

// Run on console:
// php -f .\sample\wallet-api\GenerateAddressInHDWalletWithSubchainIndexEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\HDWalletClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$walletClient = new HDWalletClient($apiContexts['BTC.main']);
$params = array('subchain_index' => 1);
$hdWalletGenerateAddressResponse = $walletClient->generateAddress('bob', $params);

ResultPrinter::printResult("Generate Address in a HDWallet", "HDWalletGenerateAddressResponse", $walletName, null, $hdWalletGenerateAddressResponse);

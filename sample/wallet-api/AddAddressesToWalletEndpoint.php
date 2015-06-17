<?php

// Run on console:
// php -f .\sample\wallet-api\AddAddressesToWalletEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\AddressList;
use BlockCypher\Api\Wallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$wallet = Wallet::get('alice', array(), $apiContext);
$addressesList = AddressList::fromAddressesArray(array(
    "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
));
$wallet->addAddresses($addressesList, array(), $apiContext);

ResultPrinter::printResult("Add Addresses to a Wallet Endpoint", "Wallet", 'alice', $addressesList, $wallet);
<?php

// php -f .\sample\docs-sample\address-api\generate-address-endpoint.php

require __DIR__ . '/../../bootstrap.php';

use BlockCypher\Api\Address;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$address = Address::create($apiContext);

ResultPrinter::printResult("Create Address", "Address", $address->getAddress(), $request, $address);
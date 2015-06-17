<?php

// php -f .\sample\address-api\address-endpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Address;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$address = Address::get('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', array(), $apiContext);

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);
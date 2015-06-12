<?php

// php -f .\sample\docs-sample\address-api\address-full-endpoint.php

require __DIR__ . '/../../bootstrap.php';

use BlockCypher\Api\Address;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$fullAddress = Address::getFullAddress('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', array(), $apiContext);

ResultPrinter::printResult("Get Full Address", "Full Address", $fullAddress->getAddress(), null, $fullAddress);
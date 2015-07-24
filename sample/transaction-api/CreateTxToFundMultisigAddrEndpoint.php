<?php

// Run on console:
// php -f .\sample\transaction-api\CreateTxToFundMultisigAddrEndpoint.php
// You can also use builders, see CreateTxToFundMultisigAddrWithBuilderEndpoint.php sample

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\TX;
use BlockCypher\Api\TXInput;
use BlockCypher\Api\TXOutput;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test3', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$input = new TXInput();
$output = new TXOutput();

$tx = new TX();
$tx
    ->setInputs(
        array(
            $input->addAddress("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4")
        )
    )
    ->setOutputs(
        array(
            $output->setAddresses(
                array(
                    "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
                    "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
                    "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
                )
            )
                ->setScriptType("multisig-2-of-3")
                ->setValue(1000)
        )
    );

$txClient = new TXClient($apiContext);
$txSkeleton = $txClient->create($tx);

ResultPrinter::printResult("Created Multisig TX", "TXSkeleton", $txSkeleton->getTx()->getHash(), $tx, $txSkeleton);
<?php

// # Create a TX using third party software
// https://github.com/Bit-Wasp/bitcoin-php

// Run on console:
// php -f .\sample\transaction-api\CreateTransactionWithThirdPartySoftware.php

use BitWasp\Bitcoin\Address\AddressFactory;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Bitcoin\Transaction\TransactionBuilder;
use BitWasp\Bitcoin\Transaction\TransactionFactory;

require __DIR__ . '/../bootstrap.php';

$debug = false;

Bitcoin::setNetwork(\BitWasp\Bitcoin\Network\NetworkFactory::bitcoinTestnet());
$network = Bitcoin::getNetwork();
$ecAdapter = Bitcoin::getEcAdapter();

// Import private key
$compressed = true;
$privateKey = PrivateKeyFactory::fromHex('1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e', $compressed);

if ($debug) {
    echo "[Key: " . $privateKey->toWif($network) . "]\n";
    echo "[Address " . $privateKey->getAddress()->getAddress($network) . "]\n";
}

// In order to run the sample you will need:
// 1.- Use the faucet to fund source address
// Faucet https://accounts.blockcypher.com/testnet-faucet?a=n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4
// 2.- Get unspent transaction outputs (UTXOs) and select one:
// https://api.blockcypher.com/v1/btc/test3/addrs/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4?unspentOnly=true
// 3.- Get the hex tx for the selected UTXO:
// https://live.blockcypher.com/btc-testnet/tx/e7f034f4a56999d04d8a3a8f07dca10e87cd4a7fd2a779e9ecd41c57afec84f8/
// 4.- Copy Tx Hex and paste here:
$txHex = '0100000001b674eafd9c1a79402661e7e7b37746145869260c29263f213f6f120ea8a95574010000006b483045022100ac406c14ef2da774d64d5504340fd278a827a99941cf0bef26fdff17c191ffa4022016a69a281ec1fcdf22c34543ff97a5c332ed12856fb44e525cf8ba3aea7c2d4101210274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdfffffffff02e8030000000000001976a914a93806b8ae200fffca565f7cf9ef3ab17d4ffe8888ac204e0000000000001976a914edeed3ce7f485e44bc33969af08ec9250510f83f88ac00000000';
$myTx = TransactionFactory::fromHex($txHex);

$spendOutput = 0;
$recipient = AddressFactory::fromString('mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj');

if ($debug) {
    echo "[Send to: " . $recipient->getAddress($network) . "]\n";
}

$builder = new TransactionBuilder($ecAdapter);
$builder
    ->spendOutput($myTx, $spendOutput)
    ->payToAddress($recipient, 1000);

if ($debug) {
    echo "Setup stage\n";
    //print_r($builder);
    echo "Signing\n";
}

// This line throws a warning but it works:
// https://github.com/mdanter/phpecc/issues/90
error_reporting(E_ERROR | E_PARSE);
$builder->signInputWithKey($privateKey, $myTx->getOutputs()->getOutput($spendOutput)->getScript(), 0);

if ($debug) {
    //print_r($builder);
    echo "Generate transaction: \n";
}

$new = $builder->getTransaction();

$hexRawTx = $new->getHex();

if ($debug) {
    echo $hexRawTx . "\n";
}

return $hexRawTx;
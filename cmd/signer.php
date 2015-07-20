<?php

// Signer console command. It allows to sign hex data with a private key
//
// Private key mus be in the same format as returned by Generate Address Endpoint:
// <a href="http://dev.blockcypher.com/?shell#generate-address-endpoint">http://dev.blockcypher.com/?shell#generate-address-endpoint</a>
//
// Run on console:
// php -f .\cmd\signer.php
//
// usage:
// php -f .\cmd\signer.php hexData hexPrivateKey  (Windows)
// php -f ./cmd/signer.php hexData hexPrivateKey  (Linux)
//
// php -f .\cmd\signer.php ed04813b11a47726c3b132a8ec5f067df8390058c463cd14e1e7216ba2f68b08 1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e
// 304402201e2d7196901bce85126691c99ef7ebe2085f9fda277380fa6f2d283daefc937302206b3cafe434469f5edcbbbb2d9000088570b89a00fc50290296bb421b16752f24
//
// You can also run the command from root folder with:
// .\signer ed04813b11a47726c3b132a8ec5f067df8390058c463cd14e1e7216ba2f68b08 1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e
// 304402201e2d7196901bce85126691c99ef7ebe2085f9fda277380fa6f2d283daefc937302206b3cafe434469f5edcbbbb2d9000088570b89a00fc50290296bb421b16752f24

if (PHP_SAPI == 'cli') {

    require __DIR__ . '/bootstrap.php';

    if (isset($argv[0])) {
        $script = $argv[0];
    };
    if (isset($argv[1])) {
        $tosign = $argv[1];
    };
    if (isset($argv[2])) {
        $privateKey = $argv[2];
    };

    if (empty($tosign)) {
        echo "Missing first argument: hex data to sign\n";
        exit(2);
    }

    if (empty($privateKey)) {
        echo "Missing second argument: private key\n";
        exit(2);
    }

    if (!ctype_xdigit($tosign)) {
        echo "Error: invalid hex data to sign.\n";
        exit(3);
    }

    if (!ctype_xdigit($privateKey)) {
        echo "Error: invalid private key. Not valid hex data.\n";
        exit(3);
    }

    //echo "tosign: ".$tosign."\n";
    //echo "privateKey: ".$privateKey."\n";

    $signature = BlockCypher\Crypto\Signer::sign($tosign, $privateKey);

    print $signature . "\n";

} else {
    echo "signer command must be executed on console\n";
    exit(1);
}
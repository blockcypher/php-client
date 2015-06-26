<?php
require __DIR__ . '/Burgomaster.php';
require __DIR__ . '/../vendor/autoload.php';

$stageDirectory = __DIR__ . '/artifacts/staging';
$projectRoot = __DIR__ . '/../';
$burgomaster = new \Burgomaster($stageDirectory, $projectRoot);
$autoloaderFilename = 'blockcypher-autoloader.php';

$metaFiles = ['README.md', 'LICENSE.md'];
foreach ($metaFiles as $file) {
    $burgomaster->deepCopy($file, $file);
}

$burgomaster->recursiveCopy('lib', 'BlockCypher', ['php', 'json']);
$burgomaster->recursiveCopy('vendor/bitwasp/bitcoin/src', 'BitWasp/Bitcoin');

$burgomaster->createAutoloader([
    'BlockCypher/functions.php',
    'BitWasp/Bitcoin/functions.php',
], $autoloaderFilename);

$burgomaster->createZip(__DIR__ . "/artifacts/blockcypher.zip");
$burgomaster->createPhar(__DIR__ . "/artifacts/blockcypher.phar", null, $autoloaderFilename);

$burgomaster->startSection('test-phar');
$burgomaster->exec('php ' . __DIR__ . '/test-phar.php');
$burgomaster->endSection();

<!-- Welcome to BlockCypher REST SDK -- >
<?php
if (PHP_SAPI == 'cli') {
    // If the index.php is called using console, we would try to host
    // the built in PHP Server
    if (version_compare(phpversion(), '5.4.0', '>=') === true) {
        //exec('php -S -t ' . __DIR__ . '/');
        $cmd = "php -S localhost:5000 -t " . __DIR__;
        $descriptors = array(
            0 => array("pipe", "r"),
            1 => STDOUT,
            2 => STDERR,
        );
        $process = proc_open($cmd, $descriptors, $pipes);
        if ($process === false) {
            fprintf(STDERR,
                "Unable to launch PHP's built-in web server.\n");
            exit(2);
        }
        fclose($pipes[0]);
        $exit = proc_close($process);
        exit($exit);
    } else {
        echo "You must be running PHP version less than 5.4. You would have to manually host the website on your local web server.\n";
        exit(2);
    }
} ?>
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>Blockcypher REST API Samples</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        /* Header Links */
        .header-link {
            position: absolute;
            left: 7px;
            opacity: 0;

        }

        h2:hover .header-link,
        h3:hover .header-link,
        h4:hover .header-link,
        h5:hover .header-link,
        h6:hover .header-link {
            opacity: 1;
        }

        .list-group-item h5 {
            padding-left: 10px;
        }

        /* End Header Links */

        li.list-group-item:hover {
            background-color: #EEE;
        }

        .jumbotron {
            background: #fff url("images/jumbotron-background.jpg") no-repeat top right;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .jumbotron {
            margin-bottom: 0px;
            padding-bottom: 20px;
        }

        .jumbotron h2, .jumbotron p, h5 {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
        }

        .footer-links a {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
        }

        @media (max-width: 992px) {
            .jumbotron {
                background-color: #FFF;
            }

            .logo {
                position: relative;
            }

            #leftNavigation {
                visibility: hidden;
            }
        }

        @media (min-width: 992px) {
            .jumbotron {
                background-color: #FFF;
            }

            .footer-div a {
                text-decoration: none;
            }

            .img-div {
                position: fixed;
                margin-left: 0px;
                padding-left: 0px;
            }

            .logo {
                top: 80px;
            }
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            /* Margin bottom by footer height */
            margin-bottom: 60px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            min-height: 60px;
            padding-top: 15px;
        }

        .footer-links, .footer-links li {
            display: inline-block;
            font-size: 110%;
            padding-left: 0px;
            padding-right: 0px;
        }

        .footer-links li {
            padding-top: 5px;
            padding-left: 5px;
        }

        .footer-links a {
            color: #428bca;;
        }

        .fixed {
            position: fixed;
        }

        .nav a {
            font-weight: bold;
        }

        .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
            background-color: #683192;
        }

        .panel-primary > .panel-heading {
            background-color: #683192;
        }

    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target="#leftNavigation" data-offset="15" class="scrollspy-example">
<!-- Main component for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 pull-left img-div">
                <img src="images/logo2_blockcypher_developer_2x.png" class="logo img-responsive"/>
            </div>
            <div class="col-md-9 pull-right">
                <h2>// REST API PHP Samples</h2>

                <p>These examples are created to experiment with the BlockCypher-PHP-SDK capabilities. Each examples
                    are
                    designed to demonstrate the default use-cases in each segment.</p>
                <br/>

                <div class="footer-div">
                    <ul class="footer-links">
                        <li>
                            <a href="http://blockcypher.github.io/php-client/" target="_blank"><i
                                    class="fa fa-github"></i>
                                BlockCypher PHP SDK</a></li>
                        <li>
                            <a href="http://dev.blockcypher.com/"
                               target="_blank"><i
                                    class="fa fa-book"></i> REST API Reference</a>
                        </li>
                        <li>
                            <a href="https://github.com/blockcypher/php-client/issues" target="_blank"><i
                                    class="fa fa-exclamation-triangle"></i> Report Issues </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 ">
            <div class="row-fluid fixed col-md-3" id="leftNavigation" role="navigation">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#chain-api">Chain API</a></li>
                    <li><a href="#block-api">Block API</a></li>
                    <li><a href="#address-api">Address API</a></li>
                    <li><a href="#wallet-api">Wallet API</a></li>
                    <li><a href="#transaction-api">Transaction API</a></li>
                    <li><a href="#microtransaction-api">Microtransaction API</a></li>
                    <li><a href="#confidence-factor">Confidence Factor</a></li>
                    <li><a href="#payment-api">Payment Forwarding</a></li>
                    <li><a href="#hook-api">Events adn Hooks</a></li>
                    <li><a href="#testing">Testing</a></li>
                    <li><a href="#signer">Signer</a></li>
                </ul>

            </div>
        </div>

        <div class="col-md-9 samples">

            <!-- chain-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="chain-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#chain-endpoint"
                            target="_blank">Chains</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get blockchain details</h5></div>
                            <div class="col-md-4">
                                <a href="chain-api/GetChain.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/chain-api/GetChain.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get blockchain feature status</h5></div>
                            <div class="col-md-4">
                                <a href="chain-api/GetFeature.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/chain-api/GetFeature.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- block-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="block-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#block-hash-endpoint"
                            target="_blank">Blocks</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block details by block hash</h5></div>
                            <div class="col-md-4">
                                <a href="block-api/GetBlock.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/block-api/GetBlock.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block details by block height</h5></div>
                            <div class="col-md-4">
                                <a href="block-api/GetBlockByHeight.php" class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/block-api/GetBlockByHeight.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple blocks at once</h5></div>
                            <div class="col-md-4">
                                <a href="block-api/GetMultipleBlocks.php" class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/block-api/GetMultipleBlocks.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block paging transaction list</h5></div>
                            <div class="col-md-4">
                                <a href="block-api/GetBlockWithPaging.php" class="btn btn-primary pull-left execute">
                                    Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/block-api/GetBlockWithPaging.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- address-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="address-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#address-api"
                            target="_blank">Addresses</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get address details</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetAddress.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get address details (BTC Tesnet)</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetAddressBtcTest3.php" class="btn btn-primary pull-left execute">
                                    Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetAddressBtcTest3.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple addresses at once</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetMultipleAddresses.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetMultipleAddresses.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get only address balance</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetOnlyBalance.php" class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetOnlyBalance.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple addresses balance at once (only balance)</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetMultipleAddressesBalance.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetMultipleAddressesBalance.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get full address</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetFullAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetFullAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple full addresses at once</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetMultipleFullAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetMultipleFullAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get address only with unspent transactions</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetAddressWithUnspentOnly.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetAddressWithUnspentOnly.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get address with paging</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GetAddressWithPaging.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GetAddressWithPaging.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Generate new address</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GenerateAddress.php" class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GenerateAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Generate new BTC Testnet address</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GenerateAddressBtcTest3.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GenerateAddressBtcTest3.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Generate new multisig address</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GenerateMultisigAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GenerateMultisigAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Generate new BTC Testnet multisig address</h5></div>
                            <div class="col-md-4">
                                <a href="address-api/GenerateMultisigAddressBtcTest3.php"
                                   class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/address-api/GenerateMultisigAddressBtcTest3.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- wallet-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="wallet-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#wallets"
                            target="_blank">Wallets</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create wallet</h5></div>
                            <div class="col-md-4">
                                <a href="wallet-api/CreateWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/CreateWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create HD wallet</h5></div>
                            <div class="col-md-4">
                                <a href="wallet-api/CreateHDWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/CreateHDWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Get wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GetWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GetWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Get HD wallet*
                                    <small>(Depends on "Create HD wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GetHDWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GetHDWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Get wallet as address*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GetWalletAsAddress.php" class="btn btn-primary pull-left execute">
                                    Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GetWalletAsAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Get wallet balance*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GetWalletBalanceAsAddressBalance.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GetWalletBalanceAsAddressBalance.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Get full wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GetWalletAsFullAddress.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GetWalletAsFullAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Add addresses to a wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/AddAddressesToWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/AddAddressesToWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Generate new address and associate it to a wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/GenerateNewAddressForWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/GenerateNewAddressForWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Derive new address in HD wallet*
                                    <small>(Depends on "Create HD wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/DeriveAddressInHDWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/DeriveAddressInHDWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Derive new address in HD wallet with subchain index*
                                    <small>(Depends on "Create HD wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/DeriveAddressInHDWalletWithSubchainIndex.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/DeriveAddressInHDWalletWithSubchainIndex.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>List wallet addresses*
                                    <small>(Depends on "Add addresses to a wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/ListWalletAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/ListWalletAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>List HD wallet addresses*
                                    <small>(Depends on "Generate address in wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/ListHDWalletAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/ListHDWalletAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Remove addresses from a wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/RemoveAddressesFromWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/RemoveAddressesFromWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Delete wallet*
                                    <small>(Depends on "Create wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/DeleteWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/DeleteWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Delete HD wallet*
                                    <small>(Depends on "Create HD wallet")</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="wallet-api/DeleteHDWallet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/wallet-api/DeleteHDWallet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- transaction-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="transaction-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#transaction-api"
                            target="_blank">Transactions</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction details</h5></div>
                            <div class="col-md-4">
                                <a href="transaction-api/GetTransaction.php" class="btn btn-primary pull-left execute">
                                    Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/GetTransaction.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple transactions at once</h5></div>
                            <div class="col-md-4">
                                <a href="transaction-api/GetMultipleTransactions.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/GetMultipleTransactions.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get unconfirmed transactions</h5></div>
                            <div class="col-md-4">
                                <a href="transaction-api/GetAllUnconfirmedTransactions.php"
                                   class="btn btn-primary pull-left execute">
                                    Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/GetAllUnconfirmedTransactions.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction paging inputs and outputs</h5></div>
                            <div class="col-md-4">
                                <a href="transaction-api/GetTransactionWithPaging.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/GetTransactionWithPaging.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction confidence</h5></div>
                            <div class="col-md-4">
                                <a href="confidence-factor/GetTransactionConfidence.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/confidence-factor/GetTransactionConfidence.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple transactions confidence at once</h5></div>
                            <div class="col-md-4">
                                <a href="confidence-factor/GetMultipleTransactionsConfidence.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/confidence-factor/GetMultipleTransactionsConfidence.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create transaction (without sending it)</h5></div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateTransaction.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateTransaction.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Create, sign and send transaction*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateAndSignAndSendTransaction.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateAndSignAndSendTransaction.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Push raw transaction</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/PushRawTransaction.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/PushRawTransaction.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Decode raw transaction</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/DecodeRawTransaction.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/DecodeRawTransaction.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Fund multisig address*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateTransactionToFundMultisigAddress.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateTransactionToFundMultisigAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Spend multisig funds*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateTransactionToSpendMultisigFunds.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateTransactionToSpendMultisigFunds.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Fund multisig address using TXBuilder*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateTxToFundMultisigAddrWithBuilder.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateTxToFundMultisigAddrWithBuilder.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Spend multisig funds using TXBuilder*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/CreateTxToSpendMultisigFundsWithBuilder.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/CreateTxToSpendMultisigFundsWithBuilder.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Create, sign and send multisig transaction*
                                    <small>(source address must contains enough balance)</small>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/SpendMultisigFundsTransaction.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/SpendMultisigFundsTransaction.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Embed data on Blockchain</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="transaction-api/EmbedDataOnBlockchain.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transaction-api/EmbedDataOnBlockchain.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- microtransaction-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="microtransaction-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#microtransaction-api"
                            target="_blank">Microtransactions API</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create from private (using client)</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="microtransaction-api/CreateMicroTXFromPrivate.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/microtransaction-api/CreateMicroTXFromPrivate.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create from pubkey (using client)</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="microtransaction-api/CreateMicroTXFromPubkey.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/microtransaction-api/CreateMicroTXFromPubkey.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create from WIF (using client)</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="microtransaction-api/CreateMicroTXFromWif.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/microtransaction-api/CreateMicroTXFromWif.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- confidence-factor -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="confidence-factor" class="panel-title"><a
                            href="http://dev.blockcypher.com/#confidence-factor"
                            target="_blank">Confidence Factor</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction confidence</h5></div>
                            <div class="col-md-4">
                                <a href="confidence-factor/GetTransactionConfidence.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/confidence-factor/GetTransactionConfidence.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- payment-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="payment-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#payment-forwarding"
                            target="_blank">Payment Forwarding</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create forwarding address</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/CreateForwardingAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/CreateForwardingAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get forwarding address</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/GetForwardingAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/GetForwardingAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple forwarding address at once</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/GetMultipleForwardingAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/GetMultipleForwardingAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>List forwarding addresses</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/CreateAndListForwardingAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/CreateAndListForwardingAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete forwarding address</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/CreateAndDeleteForwardingAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/CreateAndDeleteForwardingAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete all forwarding addresses</h5></div>
                            <div class="col-md-4">
                                <a href="payment-api/DeleteAllForwardingAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/payment-api/DeleteAllForwardingAddresses.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- hook-api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="hook-api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#events-and-hooks"
                            target="_blank">WebHooks</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create webhook</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/CreateWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/CreateWebHook.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get webhook details</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/GetWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/GetWebHook.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple webhooks at once</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/GetMultipleWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/GetMultipleWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>List all webhooks</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/CreateAndListWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/CreateAndListWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete webhook</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/CreateAndDeleteWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/CreateAndDeleteWebHook.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete all webhook</h5></div>
                            <div class="col-md-4">
                                <a href="hook-api/DeleteAllWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/hook-api/DeleteAllWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- testing -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="testing" class="panel-title"><a
                            href="http://dev.blockcypher.com/#testing"
                            target="_blank">Testing</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Generate test address</h5></div>
                            <div class="col-md-4">
                                <a href="introduction/GenerateTestAddress.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/introduction/GenerateTestAddress.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Fund address with faucet</h5></div>
                            <div class="col-md-4">
                                <a href="introduction/FundAddressWithFaucet.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/introduction/FundAddressWithFaucet.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- signer -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="signer" class="panel-title">Signer</h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Sign hex data with private key (using Signer class)</h5></div>
                            <div class="col-md-4">
                                <a href="signer/Sign.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/signer/Sign.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

        </div>
    </div>
</div>
<!-- /container -->
<hr/>
<footer class="footer">
    <div class="container">
        <div class="footer-div">
            <ul class="footer-links">
                <li>
                    <a href="http://blockcypher.github.io/php-client/" target="_blank"><i
                            class="fa fa-github"></i>
                        BlockCypher PHP SDK</a></li>
                <li>
                    <a href="http://dev.blockcypher.com/" target="_blank"><i
                            class="fa fa-book"></i> REST API Reference</a>
                </li>
                <li>
                    <a href="https://github.com/blockcypher/php-client/issues" target="_blank"><i
                            class="fa fa-exclamation-triangle"></i> Report Issues </a>
                </li>

            </ul>
        </div>
    </div>
</footer>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/scrollspy.min.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>

<script>
    $(document).ready(function () {
        if ((window.location.href.indexOf("blockcypher.github.io") >= 0)
            && (window.location.href.indexOf("dev.blockcypher.github.io") < 0)) {
            $(".execute").hide();
        }
    });
    $(function () {
        return $(".samples h5, h6").each(function (i, el) {
            var $el, icon, id;
            $el = $(el);
            id = CryptoJS.MD5(($el.html())).toString();
            //id = $el.attr('id');
            icon = '<i class="fa fa-link"></i>';
            if (id) {
                $el.parent().parent().parent().attr('id', id);
                return $el.prepend($("<a />").addClass("header-link").attr('title', "Anchor Link for this Sample").attr("href", "#" + id).html(icon));
            }
        });
    });
</script>
</body>
</html>
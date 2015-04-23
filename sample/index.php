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
                    <li><a href="#chains">Chains</a></li>
                    <li><a href="#blocks">Blocks</a></li>
                    <li><a href="#transactions">Transactions</a></li>
                    <li><a href="#zero_confirmations">0-Confirmations</a></li>
                    <li><a href="#address_details">Address Details</a></li>
                    <li><a href="#address_gen">Address Generation</a></li>
                    <li><a href="#wallet_api">Wallet</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#websockets">WebSockets</a></li>
                    <li><a href="#webhooks">WebHooks</a></li>
                    <li><a href="#payments_summary">Payments Summary</a></li>
                    <li><a href="#payments_details">Payments Details</a></li>
                    <li><a href="#generic_transactions">Generic Transactions</a></li>
                    <li><a href="#micro_transactions">Micro Transactions</a></li>
                    <li><a href="#signing_sending">Signing and sending</a></li>
                    <li><a href="#multisig">Multisig</a></li>
                </ul>

            </div>
        </div>

        <div class="col-md-9 samples">

            <!-- chains -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="chains" class="panel-title"><a
                            href="http://dev.blockcypher.com/#chains"
                            target="_blank">Chains</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get blockchain details</h5></div>
                            <div class="col-md-4">
                                <a href="chains/GetChain.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/chains/GetChain.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- blocks -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="blocks" class="panel-title"><a
                            href="http://dev.blockcypher.com/#blocks"
                            target="_blank">Blocks</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block details by block hash</h5></div>
                            <div class="col-md-4">
                                <a href="blocks/GetBlock.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/blocks/GetBlock.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block details by block height</h5></div>
                            <div class="col-md-4">
                                <a href="blocks/GetBlockByHeight.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/blocks/GetBlockByHeight.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple blocks at once</h5></div>
                            <div class="col-md-4">
                                <a href="blocks/GetMultipleBlocks.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/blocks/GetMultipleBlocks.html" class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get block paging transaction list</h5></div>
                            <div class="col-md-4">
                                <a href="blocks/GetBlockWithPaging.php" class="btn btn-primary pull-left execute"> Try
                                    It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/blocks/GetBlockWithPaging.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- transactions -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="transactions" class="panel-title"><a
                            href="http://dev.blockcypher.com/#transactions"
                            target="_blank">Transactions</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction details</h5></div>
                            <div class="col-md-4">
                                <a href="transactions/GetTransaction.php" class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transactions/GetTransaction.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple transactions at once</h5></div>
                            <div class="col-md-4">
                                <a href="transactions/GetMultipleTransactions.php"
                                   class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transactions/GetMultipleTransactions.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get transaction paging inputs and outputs</h5></div>
                            <div class="col-md-4">
                                <a href="transactions/GetTransactionWithPaging.php"
                                   class="btn btn-primary pull-left execute"> Try
                                    It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/transactions/GetTransactionWithPaging.html"
                                   class="btn btn-default pull-right">Source <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- zero_confirmations -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="zero_confirmations" class="panel-title"><a
                            href="http://dev.blockcypher.com/#zero_confirmations"
                            target="_blank">0-Confirmations</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- address_details -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="address_details" class="panel-title"><a
                            href="http://dev.blockcypher.com/#address_details"
                            target="_blank">Addresses</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get address details</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/GetAddress.php" class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple addresses at once</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/GetMultipleAddresses.php" class="btn btn-primary pull-left execute">
                                    Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetMultipleAddresses.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get only address balance</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/GetOnlyBalance.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetOnlyBalance.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple addresses balance at once (only balance)</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/GetMultipleAddressesBalance.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetMultipleAddressesBalance.html"
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
                                <a href="addresses/GetFullAddress.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetFullAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple full addresses at once</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/GetMultipleFullAddresses.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetMultipleFullAddresses.html"
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
                                <a href="addresses/GetAddressWithUnspentOnly.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetAddressWithUnspentOnly.html"
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
                                <a href="addresses/GetAddressWithPaging.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/GetAddressWithPaging.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- address_gen -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="address_gen" class="panel-title"><a
                            href="http://dev.blockcypher.com/#address_gen"
                            target="_blank">Address Generation</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create new address</h5></div>
                            <div class="col-md-4">
                                <a href="addresses/CreateAddress.php" class="btn btn-primary pull-left execute"> Try It
                                    <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/addresses/CreateAddress.html" class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- wallet_api -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="wallet_api" class="panel-title"><a
                            href="http://dev.blockcypher.com/#wallet_api"
                            target="_blank">Wallet</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- events -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="events" class="panel-title"><a
                            href="http://dev.blockcypher.com/#events"
                            target="_blank">Events</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- websockets -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="websockets" class="panel-title"><a
                            href="http://dev.blockcypher.com/#websockets"
                            target="_blank">WebSockets</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- webhooks -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="webhooks" class="panel-title"><a
                            href="http://dev.blockcypher.com/#webhooks"
                            target="_blank">WebHooks</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Create webhook</h5></div>
                            <div class="col-md-4">
                                <a href="webhooks/CreateWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/CreateWebHook.html"
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
                                <a href="webhooks/GetWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/GetWebHook.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Get multiple webHooks at once</h5></div>
                            <div class="col-md-4">
                                <a href="webhooks/GetMultipleWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/GetMultipleWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>List all WebHooks</h5></div>
                            <div class="col-md-4">
                                <a href="webhooks/CreateAndListWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/CreateAndListWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete WebHook</h5></div>
                            <div class="col-md-4">
                                <a href="webhooks/CreateAndDeleteWebHook.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/CreateAndDeleteWebHook.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Delete all WebHook</h5></div>
                            <div class="col-md-4">
                                <a href="webhooks/DeleteAllWebHooks.php"
                                   class="btn btn-primary pull-left execute"> Try It <i
                                        class="fa fa-play-circle-o"></i></a>
                                <a href="doc/webhooks/DeleteAllWebHooks.html"
                                   class="btn btn-default pull-right">Source
                                    <i
                                        class="fa fa-file-code-o"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- payments_summary -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="payments_summary" class="panel-title"><a
                            href="http://dev.blockcypher.com/#payments_summary"
                            target="_blank">Payments Summary</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- payments_details -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="payments_details" class="panel-title"><a
                            href="http://dev.blockcypher.com/#payments_details"
                            target="_blank">Payments Details</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- generic_transactions -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="generic_transactions" class="panel-title"><a
                            href="http://dev.blockcypher.com/#generic_transactions"
                            target="_blank">Generic Transactions</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- micro_transactions -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="micro_transactions" class="panel-title"><a
                            href="http://dev.blockcypher.com/#micro_transactions"
                            target="_blank">Micro Transactions</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- signing_sending -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="signing_sending" class="panel-title"><a
                            href="http://dev.blockcypher.com/#signing_sending"
                            target="_blank">Signing and Sending</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- multisig -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 id="multisig" class="panel-title"><a
                            href="http://dev.blockcypher.com/#multisig"
                            target="_blank">Multisig</a></h3>
                </div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8"><h5>Coming soon!</h5></div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

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

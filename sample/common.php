<?php

/*
	Common functions used across samples
*/

/**
 * Helper Class for Printing Results
 *
 * Class ResultPrinter
 */
class ResultPrinter
{

    private static $printResultCounter = 0;

    /**
     * Prints success response HTML TXOutput to web page.
     *
     * @param string $title
     * @param string $objectName
     * @param string $objectId
     * @param mixed $request
     * @param mixed $response
     * @param bool $forceConsole
     */
    public static function printResult(
        $title,
        $objectName,
        $objectId = null,
        $request = null,
        $response = null,
        $forceConsole = false)
    {
        self::printOutput($title, $objectName, $objectId, $request, $response, false, $forceConsole);
    }

    /**
     * Prints HTML TXOutput to web page.
     *
     * @param string $title
     * @param string $objectName
     * @param string $objectId
     * @param mixed $request
     * @param mixed $response
     * @param string $errorMessage
     * @param bool $forceConsole
     */
    public static function printOutput(
        $title,
        $objectName,
        $objectId = null,
        $request = null,
        $response = null,
        $errorMessage = null,
        $forceConsole = false
    )
    {
        if ((PHP_SAPI == 'cli') || $forceConsole == true) {
            self::$printResultCounter++;
            printf("\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n");
            printf("(%d) %s", self::$printResultCounter, strtoupper($title));
            printf("\n-------------------------------------------------------------\n\n");
            if ($objectId) {
                printf("Object with ID: %s \n", $objectId);
            }
            printf("-------------------------------------------------------------\n");
            printf("\tREQUEST:\n");
            self::printConsoleObject($request);
            printf("\n\n\tRESPONSE:\n");
            self::printConsoleObject($response, $errorMessage);
            printf("\n-------------------------------------------------------------\n\n");
        } else {

            if (self::$printResultCounter == 0) {
                include "header.html";
                echo '
                  <div class="row header"><div class="col-md-5 pull-left"><br /><a href="../index.php"><h1 class="home">&#10094;&#10094; Back to Samples</h1></a><br /></div> <br />
                  <div class="col-md-4 pull-right"><img src="../images/logo2_blockcypher_developer_2x.png" class="logo" width="300"/></div> </div>';
                echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
            }
            self::$printResultCounter++;
            echo '
        <div class="panel panel-default">
            <div class="panel-heading ' . ($errorMessage ? 'error' : '') . '" role="tab" id="heading-' . self::$printResultCounter . '">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#step-' . self::$printResultCounter . '" aria-expanded="false" aria-controls="step-' . self::$printResultCounter . '">
            ' . self::$printResultCounter . '. ' . $title . ($errorMessage ? ' (Failed)' : '') . '</a>
                </h4>
            </div>
            <div id="step-' . self::$printResultCounter . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-' . self::$printResultCounter . '">
                <div class="panel-body">
            ';

            if ($objectId) {
                echo "<div>" . ($objectName ? $objectName : "Object") . " with ID: $objectId </div>";
            }

            echo '<div class="row hidden-xs hidden-sm hidden-md"><div class="col-md-6"><h4>Request Object</h4>';
            self::printObject($request);
            if (!is_array($response)) {
                echo '</div><div class="col-md-6"><h4 class="' . ($errorMessage ? 'error' : '') . '">Response Object</h4>';
            } else {
                echo '</div><div class="col-md-6"><h4 class="' . ($errorMessage ? 'error' : '') . '">Response Objects Array</h4>';
            }
            self::printObject($response, $errorMessage);
            echo '</div></div>';

            echo '<div class="hidden-lg"><ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" ><a href="#step-' . self::$printResultCounter . '-request" role="tab" data-toggle="tab">Request</a></li>
                        <li role="presentation" class="active"><a href="#step-' . self::$printResultCounter . '-response" role="tab" data-toggle="tab">Response</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="step-' . self::$printResultCounter . '-request"><h4>Request Object</h4>';
            self::printObject($request);
            echo '</div><div role="tabpanel" class="tab-pane active" id="step-' . self::$printResultCounter . '-response"><h4>Response Object</h4>';
            self::printObject($response, $errorMessage);
            echo '</div></div></div></div>
            </div>
        </div>';
        }
        flush();
    }

    protected static function printConsoleObject($object, $error = null)
    {
        if ($error) {
            echo 'ERROR:' . $error;
        }
        if ($object) {
            if (is_a($object, 'BlockCypher\Common\BlockCypherModel')) {
                /** @var $object \BlockCypher\Common\BlockCypherModel */
                echo $object->toJSON(128);
            } elseif (is_string($object) && \BlockCypher\Validation\JsonValidator::validate($object, true)) {
                echo str_replace('\\/', '/', json_encode(json_decode($object), 128));
            } elseif (is_string($object)) {
                echo $object;
            } elseif (is_array($object)) {
                echo "[\n";
                $cont = 0;
                foreach ($object as $item) {
                    if ($cont++ > 0) echo ",\n";
                    self::printConsoleObject($item);
                }
                echo ']';
            } else {
                print_r($object);
            }
        } else {
            echo "No Data";
        }
    }

    protected static function printObject($object, $error = null)
    {
        if ($error) {
            echo '<p class="error"><i class="fa fa-exclamation-triangle"></i> ' .
                $error .
                '</p>';
        }
        if ($object) {
            if (is_a($object, 'BlockCypher\Common\BlockCypherModel')) {
                /** @var $object \BlockCypher\Common\BlockCypherModel */
                echo '<pre class="prettyprint ' . ($error ? 'error' : '') . '">' . $object->toJSON(128) . "</pre>";
            } elseif (is_string($object) && \BlockCypher\Validation\JsonValidator::validate($object, true)) {
                echo '<pre class="prettyprint ' . ($error ? 'error' : '') . '">' . str_replace('\\/', '/', json_encode(json_decode($object), 128)) . "</pre>";
            } elseif (is_string($object)) {
                echo '<pre class="prettyprint ' . ($error ? 'error' : '') . '">' . $object . '</pre>';
            } elseif (is_array($object)) {
                foreach ($object as $item) {
                    self::printObject($item, $error);
                }
            } else {
                echo "<pre>";
                print_r($object);
                echo "</pre>";
            }
        } else {
            echo "<span>No Data</span>";
        }
    }

    /**
     * Prints Error
     *
     * @param      $title
     * @param      $objectName
     * @param null $objectId
     * @param null $request
     * @param \Exception $exception
     * @param bool $forceConsole
     */
    public static function printError($title, $objectName, $objectId = null, $request = null, $exception = null, $forceConsole = false)
    {
        $data = null;
        if ($exception instanceof \BlockCypher\Exception\BlockCypherConnectionException) {
            $data = $exception->getData();
        }
        self::printOutput($title, $objectName, $objectId, $request, $data, $exception->getMessage(), $forceConsole);
    }
}

/**
 * ### getBaseUrl function
 * // utility function that returns base url for
 * // determining return/cancel urls
 *
 * @return string
 */
function getBaseUrl()
{
    if (PHP_SAPI == 'cli') {
        $trace = debug_backtrace();
        $relativePath = substr(dirname($trace[0]['file']), strlen(dirname(dirname(__FILE__))));
        echo "Warning: This sample may require a server to handle return URL. Cannot execute in command line. Defaulting URL to http://localhost$relativePath \n";
        return "http://localhost" . $relativePath;
    }
    $protocol = 'http';
    if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
        $protocol .= 's';
    }
    $host = $_SERVER['HTTP_HOST'];
    $request = $_SERVER['PHP_SELF'];
    return dirname($protocol . '://' . $host . $request);
}

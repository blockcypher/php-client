<?php

// Experimental php online tester.
// WARNING: eval should be disabled in prod or sanitize input.

require __DIR__ . '/../bootstrap.php';

// TODO:
// - nicer editor http://codemirror.net/doc/manual.html
// - catch eval exceptions. It does not work

$defaultCode = <<<'EOT'
// The following code takes you through
// the process of retrieving details about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD

$sampleAddress = '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD';

// See bootstrap.php for more on `ApiContext`
try {
    // BTC.main address
    $address = \BlockCypher\Api\Address::get($sampleAddress, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Address", $sampleAddress, null, $ex, true);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address, true);
EOT;

if(isset($_POST["code"])) {
    $code = $_POST["code"];
} else {
    $code = $defaultCode;
}

if (trim($code) != '') {

    ob_start();
    error_reporting( E_ALL );
    $result = '';

    try {
        $success = eval($code);
        if($success===false) {
            $result .= 'Error: could not run expression.';
        }
    } catch(\Exception $e){
        $result .= 'Error: exception '.get_class($e).', '.$e->getMessage().'.';
    }

    $result = ob_get_contents();
    ob_end_clean();

} else {
    $result = '';
}

?>
<html>
<head>
    <title>Sandbox</title>
</head>

<body>
    <form id="codeform" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        Code:
        <input type="submit" value="Submit" />
        <br/>
        <textarea rows="20" cols="200" name="code" form="codeform"
                  style="color: white; background-color: black"><?php echo $code; ?>
        </textarea>
    </form>
    Result:<br/>
    <textarea rows="30" cols="200" name="result" form="codeform"
              style="color: white; background-color: black"><?php echo $result; ?>
    </textarea>
</body>
</html>
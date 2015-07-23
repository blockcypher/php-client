<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;
use BlockCypher\Validation\UrlValidator;

/**
 * Class PaymentForward
 *
 * @package BlockCypher\Api
 *
 * @property string id
 * @property string token
 * @property string destination
 * @property string input_address
 * @property string process_fees_address
 * @property int process_fees_satoshis
 * @property float process_fees_percent
 * @property string callback_url
 * @property bool enable_confirmations
 * @property int mining_fees_satoshis
 * @property string[] transactions
 */
class PaymentForward extends BlockCypherResourceModel
{
    /**
     * Obtain the PaymentForward resource for the given identifier.
     *
     * @deprecated since version 1.2. Use PaymentForwardClient.
     * @param string $paymentForwardId
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public static function get($paymentForwardId, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($paymentForwardId, 'paymentForwardId');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/payments/$paymentForwardId?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new PaymentForward();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple PaymentForwards resources for the given identifiers.
     *
     * @deprecated since version 1.2. Use PaymentForwardClient.
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward[]
     */
    public static function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'token' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $webHookList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/payments/$webHookList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return PaymentForward::getList($json);
    }

    /**
     * Obtain all PaymentForward resources for the provided token.
     *
     * @deprecated since version 1.2. Use PaymentForwardClient.
     * @param array $params Parameters. Options: token
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward[]
     */
    public static function getAll($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'token' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/payments?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return PaymentForward::getList($json);
    }

    /**
     * Create a new PaymentForward.
     *
     * @deprecated since version 1.2. Use PaymentForwardClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/payments",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $this->fromJson($json);
        return $this;
    }

    /**
     * Deletes the Webhook identified by webhook_id for the application associated with access token.
     *
     * @deprecated since version 1.2. Use PaymentForwardClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($apiContext = null, $restCall = null)
    {
        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        self::executeCall(
            "$chainUrlPrefix/payments/{$this->getId()}",
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

    /**
     * Identifier of the payment forwarding request; generated when a new request is created.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Identifier of the payment forwarding request; generated when a new request is created.
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * The mandatory user token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * The mandatory user token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * The required destination address for payment forwarding.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * The required destination address for payment forwarding.
     *
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * The address which will automatically forward to destination; generated when a new request is created.
     *
     * @return string
     */
    public function getInputAddress()
    {
        return $this->input_address;
    }

    /**
     * The address which will automatically forward to destination; generated when a new request is created.
     *
     * @param string $input_address
     * @return $this
     */
    public function setInputAddress($input_address)
    {
        $this->input_address = $input_address;
        return $this;
    }

    /**
     * Optional Address to forward processing fees, if specified. Allows you to receive a fee for your own services.
     *
     * @return string
     */
    public function getProcessFeesAddress()
    {
        return $this->process_fees_address;
    }

    /**
     * Optional Address to forward processing fees, if specified. Allows you to receive a fee for your own services.
     *
     * @param string $process_fees_address
     * @return $this
     */
    public function setProcessFeesAddress($process_fees_address)
    {
        $this->process_fees_address = $process_fees_address;
        return $this;
    }

    /**
     * Optional Fixed processing fee amount to be sent to the fee address.
     * A fixed satoshi amount or a percentage is required if a process_fees_address has been specified.
     *
     * @return int
     */
    public function getProcessFeesSatoshis()
    {
        return $this->process_fees_satoshis;
    }

    /**
     * Optional Fixed processing fee amount to be sent to the fee address.
     * A fixed satoshi amount or a percentage is required if a process_fees_address has been specified.
     *
     * @param int $process_fees_satoshis
     * @return $this
     */
    public function setProcessFeesSatoshis($process_fees_satoshis)
    {
        $this->process_fees_satoshis = $process_fees_satoshis;
        return $this;
    }

    /**
     * Optional Percentage of the transaction to be sent to the fee address.
     * A fixed satoshi amount or a percentage is required if a process_fees_address has been specified.
     *
     * @return float
     */
    public function getProcessFeesPercent()
    {
        return $this->process_fees_percent;
    }

    /**
     * Optional Percentage of the transaction to be sent to the fee address.
     * A fixed satoshi amount or a percentage is required if a process_fees_address has been specified.
     *
     * @param float $process_fees_percent
     * @return $this
     */
    public function setProcessFeesPercent($process_fees_percent)
    {
        $this->process_fees_percent = $process_fees_percent;
        return $this;
    }

    /**
     * Optional The URL to call anytime a new payment is forwarded.
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callback_url;
    }

    /**
     * Optional The URL to call anytime a new payment is forwarded.
     *
     * @param string $callback_url
     * @return $this
     */
    public function setCallbackUrl($callback_url)
    {
        UrlValidator::validate($callback_url, "callback_url");
        $this->callback_url = $callback_url;
        return $this;
    }

    /**
     * Optional Whether to also call the callback_url with subsequent confirmations of the forwarding transactions.
     * Automatically sets up a WebHook.
     *
     * @return boolean
     */
    public function isEnableConfirmations()
    {
        return $this->enable_confirmations;
    }

    /**
     * Optional Whether to also call the callback_url with subsequent confirmations of the forwarding transactions.
     * Automatically sets up a WebHook.
     *
     * @return bool
     */
    public function getEnableConfirmations()
    {
        return $this->enable_confirmations;
    }

    /**
     * Optional Whether to also call the callback_url with subsequent confirmations of the forwarding transactions.
     * Automatically sets up a WebHook.
     *
     * @param boolean $enable_confirmations
     * @return $this
     */
    public function setEnableConfirmations($enable_confirmations)
    {
        $this->enable_confirmations = $enable_confirmations;
        return $this;
    }

    /**
     * Optional Mining fee amount to include in the forwarding transaction, in satoshis. If not set, defaults to 10,000.
     *
     * @return int
     */
    public function getMiningFeesSatoshis()
    {
        return $this->mining_fees_satoshis;
    }

    /**
     * Optional Mining fee amount to include in the forwarding transaction, in satoshis. If not set, defaults to 10,000.
     *
     * @param int $mining_fees_satoshis
     * @return $this
     */
    public function setMiningFeesSatoshis($mining_fees_satoshis)
    {
        $this->mining_fees_satoshis = $mining_fees_satoshis;
        return $this;
    }

    /**
     * Optional History of forwarding transaction hashes for this payment forwarding request.
     *
     * @return \string[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Optional History of forwarding transaction hashes for this payment forwarding request.
     *
     * @param \string[] $transactions
     * @return $this
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
        return $this;
    }
}
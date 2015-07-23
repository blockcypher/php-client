<?php

namespace BlockCypher\Client;

use BlockCypher\Api\PaymentForward;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;
use BlockCypher\Validation\ModelAccessorValidator;

/**
 * Class PaymentForwardClient
 *
 * @package BlockCypher\Client
 *
 */
class PaymentForwardClient extends BlockCypherClient
{
    /**
     * Create a new PaymentForward.
     *
     * OPTIONS:
     * process_fees_address (string): Address to forward processing fees, if specified.
     *                                Allows you to receive a fee for your own services.
     * process_fees_satoshis (int): Fixed processing fee amount to be sent to the fee address. A fixed satoshi amount or a
     *                        percentage is required if a process_fees_address has been
     *                        specified.
     * process_fees_percent (float): Percentage of the transaction to be sent to the fee address. A fixed satoshi amount
     *                               or a percentage is required if a process_fees_address has been specified.
     * callback_url (url): The URL to call anytime a new payment is forwarded.
     * enable_confirmations (bool): Whether to also call the callback_url with subsequent confirmations of the
     *                              forwarding transactions. Automatically sets up a WebHook.
     * mining_fees_satoshis (int): Mining fee amount to include in the forwarding transaction, in satoshis. If not set,
     *                             defaults to 10,000.
     * transactions array[string]: History of forwarding transaction hashes for this payment forwarding request.
     *
     * @param string $destination
     * @param array $options
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public function createForwardingAddress($destination, $options = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($destination, 'destination');
        ArgumentArrayValidator::validate($options, 'options');

        $paymentForward = new PaymentForward();
        $paymentForward->setDestination($destination);

        // All options correspond to a setter
        foreach ($options as $option => $optionValue) {
            if (ModelAccessorValidator::validate($paymentForward, $this->convertToCamelCase($option))) {
                $setter = "set" . $this->convertToCamelCase($option);
                $paymentForward->$setter($optionValue);
            } else {
                throw new \InvalidArgumentException("Invalid option $option");
            }
        }

        return $this->create($paymentForward, $apiContext, $restCall);
    }

    /**
     * Converts the input key into a valid Setter Method Name
     *
     * @param $key
     * @return mixed
     */
    private function convertToCamelCase($key)
    {
        return str_replace(' ', '', ucwords(str_replace(array('_', '-'), ' ', $key)));
    }

    /**
     * Create a new PaymentForward.
     *
     * @param PaymentForward $paymentForward
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public function create(PaymentForward $paymentForward, $apiContext = null, $restCall = null)
    {
        $payLoad = $paymentForward->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/payments",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $paymentForward->fromJson($json);
        return $paymentForward;
    }

    /**
     * Obtain the PaymentForward resource for the given identifier.
     *
     * @param string $paymentForwardId
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public function getForwardingAddress($paymentForwardId, $params = array(), $apiContext = null, $restCall = null)
    {
        return $this->get($paymentForwardId, $params, $apiContext, $restCall);
    }

    /**
     * Obtain the PaymentForward resource for the given identifier.
     *
     * @param string $paymentForwardId
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward
     */
    public function get($paymentForwardId, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($paymentForwardId, 'paymentForwardId');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
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
     * Deletes the PaymentForward identified by webhook_id for the application associated with access token.
     *
     * @param string $paymentForwardId
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function deleteForwardingAddress($paymentForwardId, $apiContext = null, $restCall = null)
    {
        return $this->delete($paymentForwardId, $apiContext, $restCall);
    }

    /**
     * Deletes the PaymentForward identified by webhook_id for the application associated with access token.
     *
     * @param string $paymentForwardId
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($paymentForwardId, $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($paymentForwardId, 'paymentForwardId');

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $this->executeCall(
            "$chainUrlPrefix/payments/$paymentForwardId",
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

    /**
     * Obtain all PaymentForward resources for the provided token.
     *
     * @param array $params Parameters. Options: token
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward[]
     */
    public function listForwardingAddresses($params = array(), $apiContext = null, $restCall = null)
    {
        return $this->getAll($params, $apiContext, $restCall);
    }

    /**
     * Obtain all PaymentForward resources for the provided token.
     *
     * @param array $params Parameters. Options: token
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward[]
     */
    public function getAll($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'token' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
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
     * Obtain multiple PaymentForwards resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return PaymentForward[]
     */
    public function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'token' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $paymentForwardList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/payments/$paymentForwardList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return PaymentForward::getList($json);
    }
}
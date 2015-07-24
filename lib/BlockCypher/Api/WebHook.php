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
 * Class WebHook
 *
 * It represents a WebHooks or WebSockets-based notification request, as detailed in the Events & Hooks
 * section of the documentation.
 *
 * script values:
 * pay-to-pubkey-hash (most common transaction transferring to a public key hash, and the default behavior if no out)
 * pay-to-multi-pubkey-hash (multi-signatures transaction, now actually less used than pay-to-script-hash for this purpose)
 * pay-to-pubkey (used for mining transactions)
 * pay-to-script-hash (used for transactions relying on arbitrary scripts, now used primarily for multi-sig transactions)
 * null-data (sometimes called op-return; used to embed small chunks of data in the blockchain)
 * empty (no script present, mostly used for mining transaction inputs)
 * unknown (non-standard script)*
 *
 * @package BlockCypher\Api
 *
 * @property string id
 * @property string event
 * @property string hash
 * @property string wallet_name
 * @property string token
 * @property string address
 * @property string script
 * @property string url
 * @property int callback_errors
 * @property string filter
 */
class WebHook extends BlockCypherResourceModel
{
    /**
     * Obtain the WebHook resource for the given identifier.
     *
     * @deprecated since version 1.2. Use WebHookClient.
     * @param string $webHookId
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook
     */
    public static function get($webHookId, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($webHookId, 'webHookId');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/hooks/$webHookId?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new WebHook();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple WebHooks resources for the given identifiers.
     *
     * @deprecated since version 1.2. Use WebHookClient.
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook[]
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
            "$chainUrlPrefix/hooks/$webHookList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return WebHook::getList($json);
    }

    /**
     * Obtain all WebHook resources for the provided token.
     *
     * @deprecated since version 1.2. Use WebHookClient.
     * @param array $params Parameters. Options: token
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook[]
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
            "$chainUrlPrefix/hooks?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return WebHook::getList($json);
    }

    /**
     * Create a new WebHook.
     *
     * @deprecated since version 1.2. Use WebHookClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/hooks",
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
     * @deprecated since version 1.2. Use WebHookClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($apiContext = null, $restCall = null)
    {
        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        self::executeCall(
            "$chainUrlPrefix/hooks/{$this->getId()}",
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Type of event to receive. See above for the supported event types.
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Type of event to receive. See above for the supported event types.
     *
     * @param string $event
     * @return $this
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Only objects with a matching hash will be sent. The hash can either be for a block or a transaction.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Only objects with a matching hash will be sent. The hash can either be for a block or a transaction.
     *
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * Only transactions associated with the given wallet will be sent. If used, it requires a user token.
     *
     * @return string
     */
    public function getWalletName()
    {
        return $this->wallet_name;
    }

    /**
     * Only transactions associated with the given wallet will be sent. If used, it requires a user token.
     *
     * @param string $wallet_name
     * @return $this
     */
    public function setWalletName($wallet_name)
    {
        $this->wallet_name = $wallet_name;
        return $this;
    }

    /**
     * Required if wallet_name is used.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Required if wallet_name is used.
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
     * Only transactions associated with the given address will be sent.
     * A wallet name can also be used instead of an address, which will then match on any address in the wallet.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Only transactions associated with the given address will be sent.
     * A wallet name can also be used instead of an address, which will then match on any address in the wallet.
     *
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Only transactions with an output script of the provided type will be sent.
     * The recognized types of scripts are: pay-to-pubkey-hash, pay-to-multi-pubkey-hash, pay-to-pubkey,
     * pay-to-script-hash, null-data (sometimes called OP_RETURN), empty or unknown.
     *
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Only transactions with an output script of the provided type will be sent.
     * The recognized types of scripts are: pay-to-pubkey-hash, pay-to-multi-pubkey-hash, pay-to-pubkey,
     * pay-to-script-hash, null-data (sometimes called OP_RETURN), empty or unknown.
     *
     * @param string $script
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setUrl($url)
    {
        UrlValidator::validate($url, "url");
        $this->url = $url;
        return $this;
    }

    /**
     * @return int
     */
    public function getCallbackErrors()
    {
        return $this->callback_errors;
    }

    /**
     * @param int $errors
     * @return $this
     */
    public function setCallbackErrors($errors)
    {
        $this->callback_errors = $errors;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }
}
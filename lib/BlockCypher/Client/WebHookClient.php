<?php

namespace BlockCypher\Client;

use BlockCypher\Api\WebHook;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class WebHookClient
 *
 * @package BlockCypher\Client
 */
class WebHookClient extends BlockCypherClient
{
    /**
     * Obtain the WebHook resource for the given identifier.
     *
     * @param string $webHookId
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook
     */
    public function get($webHookId, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($webHookId, 'webHookId');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
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
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook[]
     */
    public function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'token' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $webHookList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
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
     * @param array $params Parameters. Options: token
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook[]
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
     * @param WebHook $webHook
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WebHook
     */
    public function create(WebHook $webHook, $apiContext = null, $restCall = null)
    {
        $payLoad = $webHook->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/hooks",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $webHook->fromJson($json);
        return $webHook;
    }

    /**
     * Deletes the Webhook identified by webhook_id for the application associated with access token.
     *
     * @param string $webHookId
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($webHookId, $apiContext = null, $restCall = null)
    {
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $this->executeCall(
            "$chainUrlPrefix/hooks/$webHookId",
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }
}
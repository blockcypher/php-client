<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;

/**
 * Class NullData
 *
 * A NullData Object is used exclusively by our Data Endpoint to embed small pieces of data on the blockchain.
 * If your data is over 40 bytes, it cannot be embedded into the blockchain and will return an error
 *
 * @package BlockCypher\Api
 *
 * @property string data
 * @property string token
 * @property string encoding
 * @property string hash
 */
class NullData extends BlockCypherResourceModel
{
    /**
     * Allow to embed small pieces of data on the blockchain.
     *
     * @deprecated since version 1.2. Use NullDataClient.
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return NullData
     */
    public function create($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/data?" . http_build_query($params),
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
     * The string representing the data to embed, can be either hex-encoded or plaintext.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * The string representing the data to embed, can be either hex-encoded or plaintext.
     *
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Optional Your BlockCypher API token, can either be included here or as a URL Parameter in your request.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Optional Your BlockCypher API token, can either be included here or as a URL Parameter in your request.
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
     * Optional The encoding of your data, can be either string (for plaintext) or hex (for hex-encoded).
     * If not set, defaults to hex.
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Optional The encoding of your data, can be either string (for plaintext) or hex (for hex-encoded).
     * If not set, defaults to hex.
     *
     * @param string $encoding
     * @return $this
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * Optional The hash of the transaction containing your data; only part of return object.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Optional The hash of the transaction containing your data; only part of return object.
     *
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }
}
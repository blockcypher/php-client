<?php

namespace BlockCypher\Client;

use BlockCypher\Api\AddressList;
use BlockCypher\Api\HDWallet;
use BlockCypher\Api\HDWalletGenerateAddressResponse;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class HDWalletClient
 *
 * @package BlockCypher\Client
 *
 */
class HDWalletClient extends BlockCypherClient
{
    /**
     * Obtain the Wallet resource for the given identifier.
     *
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet
     */
    public function get($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($walletName, 'walletName');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/hd/$walletName?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new HDWallet();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple HDWallet resources for the given wallet names list.
     *
     * @param string[] $walletNames
     * @param array $params Parameters. Options: txstart, and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet[]
     */
    public function getMultiple($walletNames, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($walletNames, 'walletNames');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $walletList = implode(";", $walletNames);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/hd/$walletList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return HDWallet::getList($json);
    }

    /**
     * Get all addresses in a given wallet.
     *
     * @deprecated changed name to getWalletAddresses.
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressList
     */
    public function getOnlyAddresses($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        return $this->getWalletAddresses($walletName, $params, $apiContext, $restCall);
    }

    /**
     * Get all addresses in a given wallet.
     *
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressList
     */
    public function getWalletAddresses($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($walletName, 'walletName');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/hd/$walletName/addresses?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $addressList = new AddressList();
        $addressList->fromJson($json);
        return $addressList;
    }

    /**
     * Create a new HDWallet.
     *
     * @param HDWallet $hdWallet
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet
     */
    public function create(HDWallet $hdWallet, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $hdWallet->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/hd?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $returnedHDWallet = new HDWallet();
        $returnedHDWallet->fromJson($json);
        return $returnedHDWallet;
    }

    /**
     * Deletes the HDWallet identified by wallet_id for the application associated with access token.
     *
     * @param string $walletName
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $this->executeCall(
            "$chainUrlPrefix/wallets/hd/$walletName" . http_build_query($params),
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

    /**
     * A new address is generated similar to Address Generation and associated it with the given wallet.
     *
     * @param string $walletName
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWalletGenerateAddressResponse
     */
    public function generateAddress($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'subchain_index' => 1
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/hd/$walletName/addresses/generate?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $ret = new HDWalletGenerateAddressResponse();
        $ret->fromJson($json);
        return $ret;
    }
}
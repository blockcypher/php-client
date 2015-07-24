<?php

namespace BlockCypher\Client;

use BlockCypher\Api\AddressList;
use BlockCypher\Api\Wallet;
use BlockCypher\Api\WalletGenerateAddressResponse;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class WalletClient
 *
 * @package BlockCypher\Client
 *
 */
class WalletClient extends BlockCypherClient
{
    /**
     * Obtain the Wallet resource for the given identifier.
     *
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
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
            "$chainUrlPrefix/wallets/$walletName?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $returnedWallet = new Wallet();
        $returnedWallet->fromJson($json);
        return $returnedWallet;
    }

    /**
     * Obtain multiple Wallet resources for the given wallet names list.
     *
     * @param string[] $walletNames
     * @param array $params Parameters. Options: txstart, and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet[]
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
            "$chainUrlPrefix/wallets/$walletList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return Wallet::getList($json);
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
            "$chainUrlPrefix/wallets/$walletName/addresses?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new AddressList();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Create a new Wallet.
     *
     * @param Wallet $wallet
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function create(Wallet $wallet, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $wallet->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $returnedWallet = new Wallet();
        $returnedWallet->fromJson($json);
        return $returnedWallet;
    }

    /**
     * Deletes the Wallet identified by wallet_id for the application associated with access token.
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
            "$chainUrlPrefix/wallets/$walletName" . http_build_query($params),
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

    /**
     * Add Addresses to the Wallet. Associates addresses with the wallet.
     *
     * @param string $walletName
     * @param AddressList $addressList
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function addAddresses($walletName, $addressList, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($addressList, 'addressList');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $addressList->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/$walletName/addresses?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $returnedWallet = new Wallet();
        $returnedWallet->fromJson($json);
        return $returnedWallet;
    }

    /**
     * Remove Addresses to the Wallet. Addresses will no longer be associated with the wallet.
     *
     * @param string $walletName
     * @param AddressList $addressList
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function removeAddresses($walletName, $addressList, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($addressList, 'addressList');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = '';
        // Using 'address' url parameter
        if (!isset($params['address'])) {
            $params['address'] = implode(';', $addressList->getAddresses());
        } else {
            $params['address'] .= ';' . implode(';', $addressList->getAddresses());
        }

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/$walletName/addresses?" . http_build_query($params),
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $returnedWallet = new Wallet();
        $returnedWallet->fromJson($json);
        return $returnedWallet;
    }

    /**
     * A new address is generated similar to Address Generation and associated it with the given wallet.
     *
     * @param string $walletName
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WalletGenerateAddressResponse
     */
    public function generateAddress($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/wallets/$walletName/addresses/generate?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $ret = new WalletGenerateAddressResponse();
        $ret->fromJson($json);
        return $ret;
    }
}
<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class Wallet
 *
 * A resource representing a block.
 *
 * @package BlockCypher\Api
 *
 * @property string token
 * @property string name
 * @property string[] addresses
 */
class Wallet extends BlockCypherResourceModel
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
    public static function get($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($walletName, 'walletName');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/$walletName?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Wallet();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Get all addresses in a given wallet.
     *
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public static function getOnlyAddresses($walletName, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($walletName, 'walletName');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/$walletName/addresses?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Wallet();
        $ret->fromJson($json);

        // TODO: return an AddressesList instead of a Wallet when the API is fixed.
        /* Now the API returns
        {
          "token": "",
          "name": "",
          "addresses": [
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j",
            "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
          ]
        }
        and it should return
        {
          "addresses": [
            "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j",
            "18VAyux27CiWQnmYumZeTKNcaw6opvKRLq",
            "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
          ]
        }
        */

        return $ret;
    }

    /**
     * Create a new Wallet.
     *
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function create($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets?" . http_build_query($params),
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
     * Deletes the Wallet identified by wallet_id for the application associated with access token.
     *
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return bool
     */
    public function delete($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        self::executeCall(
            "$chainUrlPrefix/wallets/{$this->getName()}" . http_build_query($params),
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add Addresses to the Wallet. Associates addresses with the wallet.
     *
     * @param AddressesList $addressesList
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function addAddresses($addressesList, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($addressesList, 'addressesList');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $addressesList->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/{$this->name}/addresses?" . http_build_query($params),
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
     * Remove Addresses to the Wallet. Addresses will no longer be associated with the wallet.
     *
     * @param AddressesList $addressesList
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Wallet
     */
    public function removeAddresses($addressesList, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($addressesList, 'addressesList');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $addressesList->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/{$this->name}/addresses?" . http_build_query($params),
            "DELETE",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $this->fromJson($json);
        return $this;
    }

    /**
     * A new address is generated similar to Address Generation and associated it with the given wallet.
     *
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return WalletGenerateAddressResponse
     */
    public function generateAddress($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/{$this->name}/addresses/generate?" . http_build_query($params),
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

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Append Address to the list.
     *
     * @param string $address
     * @return $this
     */
    public function addAddress($address)
    {
        if (!$this->getAddresses()) {
            return $this->setAddresses(array($address));
        } else {
            return $this->setAddresses(
                array_merge($this->getAddresses(), array($address))
            );
        }
    }

    /**
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param \string[] $addresses
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * Remove Address from the list.
     *
     * @param string $address
     * @return $this
     */
    public function removeAddress($address)
    {
        return $this->setAddresses(
            array_diff($this->getAddresses(), array($address))
        );
    }
}
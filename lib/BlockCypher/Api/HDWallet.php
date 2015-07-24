<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class HDWallet
 *
 * A HDWallet contains addresses derived from a single seed. Like normal wallets,
 * it can be used interchangeably with all the Address API endpoints.
 *
 * @package BlockCypher\Api
 *
 * @property string token
 * @property string name
 * @property string[] addresses
 * @property bool hd
 * @property string extended_public_key
 * @property int[] subchain_indexes
 */
class HDWallet extends BlockCypherResourceModel
{
    /**
     * Obtain the Wallet resource for the given identifier.
     *
     * @deprecated since version 1.2. Use HDWalletClient.
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet
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
     * Get all addresses in a given wallet.
     *
     * @deprecated since version 1.2. Use HDWalletClient.
     * @param string $walletName
     * @param array $params Parameters.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet
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
            "$chainUrlPrefix/wallets/hd/$walletName/addresses?" . http_build_query($params),
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
     * Create a new HDWallet.
     *
     * @deprecated since version 1.2. Use HDWalletClient.
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWallet
     */
    public function create($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/hd?" . http_build_query($params),
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
     * Deletes the HDWallet identified by wallet_id for the application associated with access token.
     *
     * @deprecated since version 1.2. Use HDWalletClient.
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

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        self::executeCall(
            "$chainUrlPrefix/wallets/hd/{$this->getName()}" . http_build_query($params),
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
     * A new address is generated similar to Address Generation and associated it with the given wallet.
     *
     * @deprecated since version 1.2. Use HDWalletClient.
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return HDWalletGenerateAddressResponse
     */
    public function generateAddress($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'subchain_index' => 1
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/wallets/hd/{$this->name}/addresses/generate?" . http_build_query($params),
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

    /**
     * @return boolean
     */
    public function isHd()
    {
        return $this->hd;
    }

    /**
     * @return bool
     */
    public function getHd()
    {
        return $this->hd;
    }

    /**
     * @param boolean $hd
     * @return $this
     */
    public function setHd($hd)
    {
        $this->hd = $hd;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtendedPublicKey()
    {
        return $this->extended_public_key;
    }

    /**
     * @param string $extended_public_key
     * @return $this
     */
    public function setExtendedPublicKey($extended_public_key)
    {
        $this->extended_public_key = $extended_public_key;
        return $this;
    }

    /**
     * Append subchain index to the list.
     *
     * @param int $subchainIndex
     * @return $this
     */
    public function addSubchainIndex($subchainIndex)
    {
        if (!$this->getSubchainIndexes()) {
            return $this->setSubchainIndexes(array($subchainIndex));
        } else {
            return $this->setSubchainIndexes(
                array_merge($this->getSubchainIndexes(), array($subchainIndex))
            );
        }
    }

    /**
     * @return \int[]
     */
    public function getSubchainIndexes()
    {
        return $this->subchain_indexes;
    }

    /**
     * @param \int[] $subchain_indexes
     * @return $this
     */
    public function setSubchainIndexes($subchain_indexes)
    {
        $this->subchain_indexes = $subchain_indexes;
        return $this;
    }

    /**
     * Remove subchain index from the list.
     *
     * @param int $subchainIndex
     * @return $this
     */
    public function removeSubchainIndex($subchainIndex)
    {
        return $this->getSubchainIndexes(
            array_diff($this->getSubchainIndexes(), array($subchainIndex))
        );
    }
}
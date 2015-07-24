<?php

namespace BlockCypher\Client;

use BlockCypher\Api\Address;
use BlockCypher\Api\AddressBalance;
use BlockCypher\Api\AddressKeyChain;
use BlockCypher\Api\FullAddress;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class AddressClient
 *
 * @package BlockCypher\Client
 *
 */
class AddressClient extends BlockCypherClient
{
    /**
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressKeyChain
     */
    public function generateAddress($apiContext = null, $restCall = null)
    {
        return $this->create(null, $apiContext, $restCall);
    }

    /**
     * Create a new address.
     *
     * @param AddressKeyChain $addressKeyChain
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressKeyChain
     */
    public function create($addressKeyChain = null, $apiContext = null, $restCall = null)
    {
        if ($addressKeyChain === null) {
            $payLoad = "";
        } else {
            // multisig address
            $payLoad = $addressKeyChain->toJSON();
        }

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new AddressKeyChain();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * @deprecated since 1.2.1. Renamed to generateMultisigAddress.
     * @param array $pubkeys
     * @param string $scriptType
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressKeyChain
     */
    public function generateMultisignAddress($pubkeys, $scriptType, $apiContext = null, $restCall = null)
    {
        return $this->generateMultisigAddress($pubkeys, $scriptType, $apiContext, $restCall);
    }

    /**
     * @param array $pubkeys
     * @param string $scriptType
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressKeyChain
     */
    public function generateMultisigAddress($pubkeys, $scriptType, $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($pubkeys, 'pubkeys');

        $addressKeyChain = new AddressKeyChain();
        $addressKeyChain->setPubkeys($pubkeys);
        // script type format: 'multisig-n-of-m', where n and m are integers. For example: 'multisig-2-of-3'
        $addressKeyChain->setScriptType($scriptType);

        return $this->create($addressKeyChain, $apiContext, $restCall);
    }

    /**
     * Obtain the Address resource for the given identifier.
     *
     * @param string $address
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Address
     */
    public function get($address, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'unspentOnly' => 1,
            'before' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$address?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Address();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple Addresses resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Address[]
     */
    public function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'unspentOnly' => 1,
            'before' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $addressList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$addressList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return Address::getList($json);
    }

    /**
     * Obtain the FullAddress resource for the given address.
     *
     * @param string $address
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FullAddress
     */
    public function getFullAddress($address, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'unspentOnly' => 1,
            'before' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$address/full?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new FullAddress();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple FullAddress resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FullAddress[]
     */
    public function getMultipleFullAddresses($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'unspentOnly' => 1,
            'before' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $addressList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$addressList/full?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return FullAddress::getList($json);
    }

    /**
     * Obtain the AddressBalance resource for the given address.
     *
     * @param string $address
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressBalance
     */
    public function getBalance($address, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$address/balance" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new AddressBalance();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple AddressBalances resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressBalance[]
     */
    public function getMultipleBalances($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $addressList = implode(";", $array);

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/addrs/$addressList/balance" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return AddressBalance::getList($json);
    }
}
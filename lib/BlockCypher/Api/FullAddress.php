<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class FullAddress
 *
 * A resource representing a block.
 *
 * @package BlockCypher\Api
 *
 * @property string address Only present when object represents an address
 * @property \BlockCypher\Api\WalletInfo wallet Only present when object represents a wallet
 * @property int total_received
 * @property int total_sent
 * @property int balance
 * @property int unconfirmed_balance
 * @property int final_balance
 * @property int n_tx
 * @property int unconfirmed_n_tx
 * @property int final_n_tx
 * @property bool has_more
 * @property \BlockCypher\Api\TX[] txs
 * @property string tx_url
 */
class FullAddress extends BlockCypherResourceModel
{
    /**
     * Obtain the FullAddress resource for the given identifier.
     *
     * @deprecated since version 1.2. Use AddressClient.
     * @param string $address
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FullAddress
     */
    public static function get($address, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($address, 'address');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'unspentOnly' => 1,
            'before' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use AddressClient.
     * @param string[] $array
     * @param array $params Parameters. Options: unspentOnly, and before
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return FullAddress[]
     */
    public static function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
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

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * The requested address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * The requested address.
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
     * @return \BlockCypher\Api\Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param \BlockCypher\Api\Wallet $wallet
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Total amount, in satoshis, received by this address.
     *
     * @return int
     */
    public function getTotalReceived()
    {
        return $this->total_received;
    }

    /**
     * Total amount, in satoshis, received by this address.
     *
     * @param int $total_received
     * @return $this
     */
    public function setTotalReceived($total_received)
    {
        $this->total_received = $total_received;
        return $this;
    }

    /**
     * Total amount, in satoshis, sent by this address.
     *
     * @return int
     */
    public function getTotalSent()
    {
        return $this->total_sent;
    }

    /**
     * Total amount, in satoshis, sent by this address.
     *
     * @param int $total_sent
     * @return $this
     */
    public function setTotalSent($total_sent)
    {
        $this->total_sent = $total_sent;
        return $this;
    }

    /**
     * Balance on the specified address, in satoshi. This is the difference between outputs and inputs on this address,
     * for transactions that have been included into a block (confirmations > 0)
     *
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Balance on the specified address, in satoshi. This is the difference between outputs and inputs on this address,
     * for transactions that have been included into a block (confirmations > 0)
     *
     * @param int $balance
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }

    /**
     * Balance of unconfirmed transactions for this address, in satoshi. Can be negative
     * (if unconfirmed transactions are just spending.). Only unconfirmed transactions (haven't made it into a block)
     * are included.
     *
     * @return int
     */
    public function getUnconfirmedBalance()
    {
        return $this->unconfirmed_balance;
    }

    /**
     * Balance of unconfirmed transactions for this address, in satoshi. Can be negative
     * (if unconfirmed transactions are just spending.). Only unconfirmed transactions (haven't made it into a block)
     * are included.
     *
     * @param int $unconfirmed_balance
     * @return $this
     */
    public function setUnconfirmedBalance($unconfirmed_balance)
    {
        $this->unconfirmed_balance = $unconfirmed_balance;
        return $this;
    }

    /**
     * Balance including confirmed and unconfirmed transactions for this address, in satoshi.
     *
     * @return int
     */
    public function getFinalBalance()
    {
        return $this->final_balance;
    }

    /**
     * Balance including confirmed and unconfirmed transactions for this address, in satoshi.
     *
     * @param int $final_balance
     * @return $this
     */
    public function setFinalBalance($final_balance)
    {
        $this->final_balance = $final_balance;
        return $this;
    }

    /**
     * Number of confirmed transactions on the specified address. Only transactions that have made it into a block
     * (confirmations > 0) are counted.
     *
     * @return int
     */
    public function getNTx()
    {
        return $this->n_tx;
    }

    /**
     * Number of confirmed transactions on the specified address. Only transactions that have made it into a block
     * (confirmations > 0) are counted.
     *
     * @param int $n_tx
     * @return $this
     */
    public function setNTx($n_tx)
    {
        $this->n_tx = $n_tx;
        return $this;
    }

    /**
     * All unconfirmed transaction inputs and outputs for the specified address.
     *
     * @return int
     */
    public function getUnconfirmedNTx()
    {
        return $this->unconfirmed_n_tx;
    }

    /**
     * All unconfirmed transaction inputs and outputs for the specified address.
     *
     * @param int $unconfirmed_n_tx
     * @return $this
     */
    public function setUnconfirmedNTx($unconfirmed_n_tx)
    {
        $this->unconfirmed_n_tx = $unconfirmed_n_tx;
        return $this;
    }

    /**
     * Final number of transactions, including unconfirmed transactions, for this address.
     *
     * @return int
     */
    public function getFinalNTx()
    {
        return $this->final_n_tx;
    }

    /**
     * Final number of transactions, including unconfirmed transactions, for this address.
     *
     * @param int $final_n_tx
     * @return $this
     */
    public function setFinalNTx($final_n_tx)
    {
        $this->final_n_tx = $final_n_tx;
        return $this;
    }

    /**
     * @return boolean
     */
    public function hasMore()
    {
        return $this->has_more;
    }

    /**
     * @param boolean $has_more
     * @return $this
     */
    public function setHasMore($has_more)
    {
        $this->has_more = $has_more;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasMore()
    {
        return $this->has_more;
    }
    /**
     * Alias for addTx method.
     *
     * @param \BlockCypher\Api\TX $transaction
     * @return $this
     */
    public function addTransaction($transaction)
    {
        return $this->addTx($transaction);
    }

    /**
     * Append TX to the list.
     *
     * @param \BlockCypher\Api\TX $tx
     * @return $this
     */
    public function addTx($tx)
    {
        if (!$this->getTxs()) {
            return $this->setTxs(array($tx));
        } else {
            return $this->setTxs(
                array_merge($this->getTxs(), array($tx))
            );
        }
    }

    /**
     * All transaction inputs and outputs for the specified address.
     *
     * @return \BlockCypher\Api\TX[]
     */
    public function getTxs()
    {
        return $this->txs;
    }

    /**
     * All transaction inputs and outputs for the specified address.
     *
     * @param \BlockCypher\Api\TX[] $tx
     *
     * @return $this
     */
    public function setTxs($tx)
    {
        $this->txs = $tx;
        return $this;
    }

    /**
     * Alias for getTxs method.
     *
     * @return \BlockCypher\Api\TX[]
     */
    public function getTransactions()
    {
        return $this->getTxs();
    }

    /**
     * Alias for setTxs method.
     *
     * @param \BlockCypher\Api\TX[] $transactions
     *
     * @return $this
     */
    public function setTransactions($transactions)
    {
        return $this->setTxs($transactions);
    }

    /**
     * Alias for removeTx method.
     *
     * @param \BlockCypher\Api\TX $transaction
     * @return $this
     */
    public function removeTransaction($transaction)
    {
        return $this->removeTx($transaction);
    }

    /**
     * Remove TX from the list.
     *
     * @param \BlockCypher\Api\TX $tx
     * @return $this
     */
    public function removeTx($tx)
    {
        return $this->setTxs(
            array_diff($this->getTxs(), array($tx))
        );
    }

    /**
     * To retrieve base URL transactions. To get the full URL, concatenate this URL with the transaction's hash.
     *
     * @return string
     */
    public function getTxUrl()
    {
        return $this->tx_url;
    }

    /**
     * To retrieve base URL transactions. To get the full URL, concatenate this URL with the transaction's hash.
     *
     * @param string $tx_url
     * @return $this
     */
    public function setTxUrl($tx_url)
    {
        $this->tx_url = $tx_url;
        return $this;
    }
}
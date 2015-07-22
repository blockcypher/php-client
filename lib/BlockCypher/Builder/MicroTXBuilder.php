<?php

namespace BlockCypher\Builder;

use BlockCypher\Api\MicroTX;

/**
 * Class MicroTXBuilder
 */
class MicroTXBuilder
{
    /**
     * @var string
     */
    private $fromPubkey;

    /**
     * @var string
     */
    private $fromPrivate;

    /**
     * @var string
     */
    private $fromWif;

    /**
     * @var string
     */
    private $toAddress;

    /**
     * @var int
     */
    private $valueSatoshis;

    function __construct()
    {
        $this->fromPubkey = null;
        $this->fromPrivate = null;
        $this->fromWif = null;
        $this->toAddress = null;
        $this->valueSatoshis = null;
    }

    /**
     * Alias for newMicroTX method.
     *
     * @return MicroTXBuilder
     */
    public static function aMicroTX()
    {
        return self::newMicroTX();
    }

    /**
     * @return MicroTXBuilder
     */
    public static function newMicroTX()
    {
        return new MicroTXBuilder();
    }

    /**
     * @param string $fromPubkey
     * @return $this
     */
    public function fromPubkey($fromPubkey)
    {
        $this->fromPubkey = $fromPubkey;
        return $this;
    }

    /**
     * @param string $fromPrivate
     * @return $this
     */
    public function fromPrivate($fromPrivate)
    {
        $this->fromPrivate = $fromPrivate;
        return $this;
    }

    /**
     * @param string $fromWif
     * @return $this
     */
    public function fromWif($fromWif)
    {
        $this->fromWif = $fromWif;
        return $this;
    }

    /**
     * @param string $toAddress
     * @return $this
     */
    public function toAddress($toAddress)
    {
        $this->toAddress = $toAddress;
        return $this;
    }

    /**
     * @param int $valueSatoshis
     * @return $this
     */
    public function withValueInSatoshis($valueSatoshis)
    {
        $this->valueSatoshis = $valueSatoshis;
        return $this;
    }

    /**
     * @return MicroTX
     */
    public function build()
    {
        $microTX = new MicroTX();

        if ($this->fromPubkey !== null) $microTX->setFromPubkey($this->fromPubkey);
        if ($this->fromPrivate !== null) $microTX->setFromPrivate($this->fromPrivate);
        if ($this->fromWif !== null) $microTX->setFromWif($this->fromWif);
        $microTX->setToAddress($this->toAddress);
        $microTX->setValueSatoshis($this->valueSatoshis);

        return $microTX;
    }
}
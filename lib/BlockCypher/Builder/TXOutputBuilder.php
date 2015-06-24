<?php

namespace BlockCypher\Builder;

use BlockCypher\Api\TXOutput;

/**
 * Class TXOutputBuilder
 */
class TXOutputBuilder
{
    /**
     * @var string[]
     */
    private $addresses;

    /**
     * @var string
     */
    private $scryptType;

    /**
     * @var int
     */
    private $value;

    function __construct()
    {
        $this->addresses = array();
        $this->scryptType = null;
        $this->value = null;
    }

    /**
     * @return TXOutputBuilder
     */
    public static function aTXOutput()
    {
        return new TXOutputBuilder();
    }

    /**
     * @param string $scryptType
     * @return $this
     */
    public function withScryptType($scryptType)
    {
        $this->scryptType = $scryptType;
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function withValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function addAddress($address)
    {
        $this->addresses[] = $address;
        return $this;
    }

    /**
     * @return TXOutput
     */
    public function build()
    {
        $txOutput = new TXOutput();

        $txOutput->setAddresses($this->addresses);
        $txOutput->setScriptType($this->scryptType);
        $txOutput->setValue($this->value);

        return $txOutput;
    }
}
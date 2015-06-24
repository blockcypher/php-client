<?php

namespace BlockCypher\Builder;

use BlockCypher\Api\TX;
use BlockCypher\Api\TXInput;
use BlockCypher\Api\TXOutput;

/**
 * Class TXBuilder
 */
class TXBuilder
{
    /**
     * @var TXInput[]
     */
    private $inputs;

    /**
     * @var TXOutput[]
     */
    private $outputs;

    function __construct()
    {
        $this->inputs = array();
        $this->outputs = array();
    }

    /**
     * @return TXBuilder
     */
    public static function aTX()
    {
        return new TXBuilder();
    }

    /**
     * @param TXInput $input
     * @return $this
     */
    public function addTXInput(TXInput $input)
    {
        $this->inputs[] = $input;
        return $this;
    }

    /**
     * @param TXOutput $output
     * @return $this
     */
    public function addTXOutput(TXOutput $output)
    {
        $this->outputs[] = $output;
        return $this;
    }

    /**
     * @return TX
     */
    public function build()
    {
        $tx = new TX();

        $tx->setInputs($this->inputs);
        $tx->setOutputs($this->outputs);

        return $tx;
    }
}
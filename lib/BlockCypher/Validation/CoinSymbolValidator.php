<?php

namespace BlockCypher\Validation;

use BlockCypher\Core\BlockCypherCoinSymbolConstants;

/**
 * Class CoinSymbolValidator
 *
 * @package BlockCypher\Validation
 */
class CoinSymbolValidator
{
    /**
     * Helper method for validating an argument if it is valid coin symbol
     *
     * @param mixed $argument
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        // DEBUG
        //echo "Argument: $argument\n";
        //echo "Argument name: $argumentName\n";

        if (!in_array($argument, BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST())) {
            throw new \InvalidArgumentException("Argument with name $argumentName and value '$argument' is not a valid coin symbol value. Allowed values: " . implode(', ', BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST()));
        }
        return true;
    }
}


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

        if ($argument === null) {
            self::throwException($argument, $argumentName);
        }

        if (gettype($argument) != 'string') {
            self::throwException($argument, $argumentName);
        }

        if (gettype($argument) == 'string' && trim($argument) == '') {
            self::throwException($argument, $argumentName);
        }

        if (!in_array($argument, BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST())) {
            self::throwException($argument, $argumentName);
        }

        return true;
    }

    private static function throwException($argument, $argumentName)
    {
        throw new \InvalidArgumentException("Argument with name $argumentName and value '$argument' is not a valid coin symbol value. Allowed values: " . implode(', ', BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST()));
    }
}


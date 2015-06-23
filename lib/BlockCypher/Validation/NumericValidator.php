<?php

namespace BlockCypher\Validation;

/**
 * Class NumericValidator
 *
 * @package BlockCypher\Validation
 */
class NumericValidator
{

    /**
     * Helper method for validating an argument if it is numeric
     *
     * @param mixed $argument
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        if (trim($argument) != null && !is_numeric($argument)) {
            throw new \InvalidArgumentException("Argument with name $argumentName is not a valid numeric value");
        }
        return true;
    }
}

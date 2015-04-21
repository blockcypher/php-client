<?php

namespace BlockCypher\Validation;

/**
 * Class ArrayValidator
 *
 * @package BlockCypher\Validation
 */
class ArrayValidator
{

    /**
     * Helper method for validating an argument if it is an array
     *
     * @param mixed $argument
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate($argument, $argumentName = null)
    {
        if (!is_array($argument)) {
            throw new \InvalidArgumentException("$argumentName is not an array");

        }
        return true;
    }
}

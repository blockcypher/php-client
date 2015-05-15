<?php

namespace BlockCypher\Validation;

/**
 * Class ArgumentArrayValidator
 *
 * @package BlockCypher\Validation
 */
class ArgumentArrayValidator
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
            throw new \InvalidArgumentException("Argument with name $argumentName is not an array");

        }
        foreach ($argument as $item) {
            if ($item === null) {
                // Error if Object Null
                throw new \InvalidArgumentException("Argument with name $argumentName item cannot be null");
            } else if (gettype($item) == 'string' && trim($item) == '') {
                // Error if String Empty
                throw new \InvalidArgumentException("Argument with name $argumentName item string cannot be empty");
            }
        }
        return true;
    }
}

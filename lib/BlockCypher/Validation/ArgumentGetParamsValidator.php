<?php

namespace BlockCypher\Validation;

use BlockCypher\Core\BlockCypherConfigManager;
use BlockCypher\Core\BlockCypherLoggingManager;

/**
 * Class ArgumentGetParamsValidator
 *
 * @package BlockCypher\Validation
 */
class ArgumentGetParamsValidator
{

    /**
     * Helper method for validating an argument if it is an array of GET params
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

    /**
     * @param $params
     * @param $allowedParams
     * @param string $validationLevel allows override global validation level settings
     * @return array
     */
    public static function sanitize($params, $allowedParams, $validationLevel = null)
    {
        $notAllowedParams = self::getNotAllowedParams($params, $allowedParams);
        if (count($notAllowedParams) > 0) {
            if ($validationLevel === null) {
                $validationLevel = BlockCypherConfigManager::getInstance()->get('validation.level');
            }
            foreach ($notAllowedParams as $key => $value) {
                $validationMessage = "Param {$key} not allowed: It can be a typo in the param name or you should update the PHP SDK library.";
                switch ($validationLevel) {
                    case 'log':
                        // logs the error message to logger only (default)
                        $logger = BlockCypherLoggingManager::getInstance(__CLASS__);
                        $logger->warning($validationMessage);
                        break;
                    case 'strict':
                        // throws a php notice message
                        trigger_error($validationMessage, E_USER_NOTICE);
                        break;
                    case 'disable':
                        // disable the validation
                        break;
                }
            }

            if ($validationLevel == 'strict') {
                // Do not add not allowed params to the url
                $params = array_intersect_key($params, $allowedParams);
                return $params;
            }
            return $params;
        }
        return $params;
    }

    /**
     * Return all params present in $params and not present in $allowedParams
     *
     * @param array $params
     * @param array $allowedParams
     * @return array
     */
    private static function getNotAllowedParams($params, $allowedParams)
    {
        $notAllowedParams = array();
        foreach ($params as $key => $value) {
            if (!isset($allowedParams[$key])) {
                $notAllowedParams[$key] = $value;
            }
        }

        return $notAllowedParams;
    }
}

<?php

namespace BlockCypher\Validation;

/**
 * Class TokenValidator
 *
 * @package BlockCypher\Validation
 */
class TokenValidator
{
    /**
     * Helper method for validating tokens.
     *
     * @param string $token
     * @return bool
     */
    public static function validate($token)
    {
        if ($token === null) {
            return false;
        }

        if (gettype($token) == 'string' && trim($token) == '') {
            // False if String Empty
            return false;
        }

        if (strlen($token) < 20) return false;
        if (strlen($token) > 50) return false;

        // Type 0: c0afcccdde5081d6429de37d16166ead
        $type0RegExpression = '/(^[a-z0-9]+$)/i';

        // Type 1: de305d54-75b4-431b-adb2-eb6b9e546014
        // UUID strict: http://en.wikipedia.org/wiki/Universally_unique_identifier#Definition
        $type1RegExpression = '/(^[a-f0-9]{8}\-[a-f0-9]{4}\-[a-f0-9]{4}\-[a-f0-9]{4}\-[a-f0-9]{12}$)/i';

        if (preg_match($type0RegExpression, $token) == false
            && preg_match($type1RegExpression, $token) == false
        ) {
            return false;
        }

        return true;
    }
}
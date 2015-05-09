<?php

namespace BlockCypher\Converter;

/*
 * Numeric values of the constants. Not all are available in all PHP version.
 *
 * JSON_HEX_TAG => 1
 * JSON_HEX_AMP => 2
 * JSON_HEX_APOS => 4
 * JSON_HEX_QUOT => 8
 * JSON_FORCE_OBJECT => 16
 * JSON_NUMERIC_CHECK => 32
 * JSON_UNESCAPED_SLASHES => 64
 * JSON_PRETTY_PRINT => 128
 * JSON_UNESCAPED_UNICODE => 256
 *
 * JSON_ERROR_DEPTH => 1
 * JSON_ERROR_STATE_MISMATCH => 2
 * JSON_ERROR_CTRL_CHAR => 3
 * JSON_ERROR_SYNTAX => 4
 * JSON_ERROR_UTF8 => 5
 *
 * JSON_OBJECT_AS_ARRAY => 1
 * JSON_BIGINT_AS_STRING => 2
 *
 * JSON_HEX_TAG (integer)
 * All < and > are converted to \u003C and \u003E. Available since PHP 5.3.0.
 * JSON_HEX_AMP (integer)
 * All &s are converted to \u0026. Available since PHP 5.3.0.
 * JSON_HEX_APOS (integer)
 * All ' are converted to \u0027. Available since PHP 5.3.0.
 * JSON_HEX_QUOT (integer)
 * All " are converted to \u0022. Available since PHP 5.3.0.
 * JSON_FORCE_OBJECT (integer)
 * Outputs an object rather than an array when a non-associative array is used. Especially useful when the recipient of the output is expecting an object and the array is empty. Available since PHP 5.3.0.
 * JSON_NUMERIC_CHECK (integer)
 * Encodes numeric strings as numbers. Available since PHP 5.3.3.
 * JSON_BIGINT_AS_STRING (integer)
 * Encodes large integers as their original string value. Available since PHP 5.4.0.
 * JSON_PRETTY_PRINT (integer)
 * Use whitespace in returned data to format it. Available since PHP 5.4.0.
 * JSON_UNESCAPED_SLASHES (integer)
 * Don't escape /. Available since PHP 5.4.0.
 * JSON_UNESCAPED_UNICODE (integer)
 * Encode multibyte Unicode characters literally (default is to escape as \uXXXX). Available since PHP 5.4.0.
 * JSON_PRESERVE_ZERO_FRACTION (integer)
 * Ensures that float values are always encoded as a float value. Available since PHP 5.6.6.
 */

if (!defined('JSON_BIGINT_AS_STRING')) {
    define('JSON_BIGINT_AS_STRING', 2);
}

if (!defined('JSON_NUMERIC_CHECK')) {
    define('JSON_NUMERIC_CHECK', 32);
}

if (!defined('JSON_HEX_AMP')) {
    define('JSON_HEX_AMP', 2);
}

if (!defined('JSON_UNESCAPED_SLASHES')) {
    define('JSON_UNESCAPED_SLASHES', 64);
}

/**
 * Class JsonConverter
 * @package BlockCypher\Converter
 */
class JsonConverter
{
    /**
     * @param mixed $value
     * @param int $options
     * @param int $depth
     * @return string
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        // 5.6.6	JSON_PRESERVE_ZERO_FRACTION option was added.
        // 5.5.0	depth parameter was added.
        // 5.4.0	JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES, and JSON_UNESCAPED_UNICODE options were added.
        // 5.3.3	JSON_NUMERIC_CHECK option was added.
        // 5.3.0	The options parameter was added.

        if (version_compare(phpversion(), '5.5.0', '>=') === true) {
            return json_encode($value, $options, $depth);
        }

        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_encode($value, $options);
        }

        if (version_compare(phpversion(), '5.3.3', '>=') === true) {
            $json = json_encode($value, $options);
            // Available since PHP 5.4.0.
            if ($options & JSON_UNESCAPED_SLASHES) {
                $json = str_replace('\\/', '/', $json);
            }
            return $json;
        }

        if (version_compare(phpversion(), '5.3.0', '>=') === true) {
            $json = json_encode($value, $options);
            // Available since PHP 5.3.3.
            if ($options & JSON_NUMERIC_CHECK) {
                // TODO: implement option for lower PHP versions
                // IF string contains number then remove "
            }
            return $json;
        }

        $json = json_encode($value, $options);

        // Available since PHP 5.3.0.
        if ($options & JSON_HEX_AMP) {
            $json = str_replace('&', "\\u0026", $json);
        }

        return $json;
    }

    /**
     * @param string
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     */
    public static function decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        // 5.6.0	Invalid non-lowercased variants of the true, false and null literals are no longer accepted as valid input, and will generate warnings.
        // 5.4.0	The options parameter was added.
        // 5.3.0	Added the optional depth. The default recursion depth was increased from 128 to 512
        // 5.2.3	The nesting limit was increased from 20 to 128
        // 5.2.1	Added support for JSON decoding of basic types.

        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_decode($json, $assoc, $depth, $options);
        }

        // Available since PHP 5.4.0.
        if ($options & JSON_BIGINT_AS_STRING) {
            $json = preg_replace('/\: *([0-9]+\.?[0-9e+\-]*)/', ':"\\1"', $json);
        }

        if (version_compare(phpversion(), '5.3.0', '>=') === true) {
            return json_decode($json, $assoc, $depth);
        }

        return json_decode($json, $assoc);
    }
}

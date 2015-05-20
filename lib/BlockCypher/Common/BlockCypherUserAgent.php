<?php

namespace BlockCypher\Common;

/**
 * Class BlockCypherUserAgent
 * BlockCypherUserAgent generates User Agent for curl requests
 *
 * @package BlockCypher\Common
 */
class BlockCypherUserAgent
{

    /**
     * Returns the value of the User-Agent header
     * Add environment values and php version numbers
     *
     * @param string $sdkName
     * @param string $sdkVersion
     * @return string
     */
    public static function getValue($sdkName, $sdkVersion)
    {

        $featureList = array(
            'lang=PHP',
            'v=' . PHP_VERSION,
            'bit=' . self::_getPHPBit(),
            'os=' . str_replace(' ', '_', php_uname('s') . ' ' . php_uname('r')),
            'machine=' . php_uname('m')
        );
        if (defined('OPENSSL_VERSION_TEXT')) {
            $opensslVersion = explode(' ', OPENSSL_VERSION_TEXT);
            $featureList[] = 'openssl=' . $opensslVersion[1];
        }
        if (function_exists('curl_version')) {
            $curlVersion = curl_version();
            $featureList[] = 'curl=' . $curlVersion['version'];
        }

        $userAgent = sprintf("BlockCypherSDK/%s %s (%s)", $sdkName, $sdkVersion, implode(';', $featureList));

        // Test UserAgent: uncomment to force a User Agent value. For debug purposes.
        //$userAgent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36";

        return $userAgent;
    }

    /**
     * Gets PHP Bit version
     *
     * @return int|string
     */
    private static function _getPHPBit()
    {
        switch (PHP_INT_SIZE) {
            case 4:
                return '32';
            case 8:
                return '64';
            default:
                return PHP_INT_SIZE;
        }
    }
}

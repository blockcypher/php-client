<?php

namespace BlockCypher\Converter;

class BtcConverter
{
    const SATOSHIS_PER_BTC = 100000000.00; // 10^8
    const SATOSHIS_PER_MILLIBITCOIN = 100000.00; // 10^5

    /**
     * Convert BTC to satoshis
     *
     * @param int|float $btc
     * @return int|float
     */
    public static function btcToSatoshis($btc)
    {
        if (!is_numeric($btc))
            throw new \InvalidArgumentException("$btc must be numeric");

        return ($btc * self::SATOSHIS_PER_BTC);
    }

    /**
     * @param int|float $satoshis
     * @param int $decimals
     * @return float
     */
    public static function satoshisToBtcRounded($satoshis, $decimals = 4)
    {
        if (!is_numeric($satoshis))
            throw new \InvalidArgumentException("$satoshis must be numeric");

        if (!is_int($decimals))
            throw new \InvalidArgumentException("$decimals must be integer");

        $btc = self::satoshisToBtc($satoshis);

        if ($decimals == 0) {
            $value = $btc;
        } else {
            $value = round($btc, $decimals);
        }

        return $value;
    }

    /**
     * Convert satoshis to BTC
     *
     * @param int|float $satoshis
     * @return float
     */
    public static function satoshisToBtc($satoshis)
    {
        if (!is_numeric($satoshis))
            throw new \InvalidArgumentException("$satoshis must be numeric");

        return (float)($satoshis) / (float)(self::SATOSHIS_PER_BTC);
    }
}
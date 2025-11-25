<?php

use Brick\Money\Money;

if (!function_exists('numberShortner')) {
    /**
     * Shorten large numbers into readable format
     *
     * @param  int $number
     * @return string
     */
    function numberShortner($number): string
    {
        if ($number < 1000) {
            return (string)floor($number);
        } elseif ($number < 1000000) {
            return floor($number / 1000) . 'K+';
        } elseif ($number < 1000000000) {
            return floor($number / 1000000) . 'M+';
        } elseif ($number < 1000000000000) {
            return floor($number / 1000000000) . 'B+';
        } else {
            return floor($number / 1000000000000) . 'T+';
        }
    }
}

if (!function_exists('price')) {
    /**
     * Format price with currency symbol
     *
     * @param  float $price
     * @param  bool $format
     * @param  int $fraction
     * @param  string $symbol
     * @param  string $currency
     * @return string|Money
     */
    function price($price, $format = false, $fraction = 0, $symbol = 'Rp', $currency = 'IDR')
    {
        try {
            $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
            $formatter->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $symbol);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $fraction);
            $money = Money::of(intval($price), $currency);
            return $format ? $money->formatWith($formatter) : $money;
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('priceToNumber')) {
    /**
     * Convert price format to number
     *
     * @param  string $value
     * @param  string $suffix
     * @return string
     */
    function priceToNumber($value, $suffix = ',00')
    {
        try {
            $trim = substr($value, 0, -strlen($suffix));
            return preg_replace("/[^0-9]/", "", $trim);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('number')) {
    /**
     * Provide usual numbers into number format
     *
     * @param  double|int $number
     * @param  double|int $decimals
     * @return string
     */
    function number($number, $decimals = 2)
    {
        try {
            return number_format(preg_replace('/\D/', '', $number), $decimals);
        } catch (Exception $exeception) {
            return null;
        }
    }

    if (!function_exists('cleanCurrency')) {
        /**
         * Cleans a formatted currency string by removing currency symbols, thousand separators,
         * and unnecessary decimal parts, returning only the numeric value.
         *
         * @param string $formattedNumber The formatted currency string to be cleaned.
         * @return string The cleaned numeric value as a string.
         */
        function cleanCurrency($formattedNumber)
        {
            // Remove trailing decimals like .00 or ,00
            $cleaned = preg_replace('/(\.00|,00)$/', '', $formattedNumber);
            // Remove the "Rp " prefix and any whitespace
            $cleaned = number(preg_replace(['/Rp\s?/', '/\s+/'], '', $cleaned));
            // Remove trailing decimals like .00 or ,00
            $cleaned = preg_replace('/(\.00|,00)$/', '', $cleaned);

            return preg_replace('/\D/', '', $cleaned);
        }
    }
}
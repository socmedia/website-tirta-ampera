<?php

use Carbon\CarbonInterval;

if (!function_exists('minutesToHours')) {
    /**
     * Get total hour from total minutes
     *
     * @param  int $minutes
     * @param  string $suffix
     * @param  boolean $withMinute
     * @return int|string
     */
    function minutesToHours(
        int $minutes,
        string $suffix = '',
        bool $withMinute = false
    ) {
        try {
            $hours = CarbonInterval::minutes($minutes)->cascade();

            if ($withMinute) {
                return $hours->h ? $hours->h . 'h ' . $hours->i . 'm' : $hours->i . 'm';
            }

            return round($hours->totalHours, 1) . $suffix;
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('convertSecond')) {
    /**
     * Get video duration from YouTube video API
     *
     * @param  ?int $value
     * @return ?array
     */
    function convertSecond(?int $value)
    {
        try {
            return CarbonInterval::make($value);
        } catch (Exception $exception) {
            return null;
        }
    }
}

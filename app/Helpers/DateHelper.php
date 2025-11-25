<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

if (!function_exists('age')) {
    /**
     * Calculate age from the given date.
     *
     * @param string $date
     * @param string $term
     * @return string|null
     */
    function age($date, $term = ' y.o')
    {
        try {
            return $date ? Carbon::parse($date)->age . $term : null;
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('formatDateRange')) {
    /**
     * Format a human-readable date range from two dates.
     *
     * Example outputs:
     * - "01-15 April 2025" if within the same month and year.
     * - "28 Feb - 02 March 2025" if different months but same year.
     * - "30 Dec 2024 - 02 Jan 2025" if different years.
     *
     * @param string|\Carbon\Carbon $start
     * @param string|\Carbon\Carbon $end
     * @return string|null
     */
    function formatDateRange($start, $end)
    {
        try {
            $start = carbon($start);
            $end = carbon($end);

            $sameYear = $start->year === $end->year;
            $sameMonth = $sameYear && $start->month === $end->month;

            if ($sameMonth) {
                return $start->format('d') . '-' . $end->format('d F Y');
            }

            if ($sameYear) {
                return $start->format('d F') . ' - ' . $end->format('d F Y');
            }

            return $start->format('d F Y') . ' - ' . $end->format('d F Y');
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('generatePeriods')) {
    /**
     * Generate a sequence of periods between two dates based on the given interval.
     *
     * Supported intervals: hour, day, 3 days, week, month, year.
     *
     * @param \Carbon\Carbon|string $start
     * @param \Carbon\Carbon|string $end
     * @param string $interval
     * @return \Illuminate\Support\Collection
     *
     * @throws \Exception
     */
    function generatePeriods($start, $end, string $interval): Collection
    {
        $start = $start instanceof Carbon ? $start : carbon($start);
        $end = $end instanceof Carbon ? $end : carbon($end);

        $periods = collect();
        $current = $start->copy();

        while ($current <= $end) {
            $periods->push($current->copy());

            $current = match ($interval) {
                'hour' => $current->addHour(),
                'day' => $current->addDay(),
                '3 days' => $current->addDays(3),
                'week' => $current->addWeek(),
                'month' => $current->addMonth(),
                'year' => $current->addYear(),
                default => throw new \Exception("Invalid interval: {$interval}"),
            };
        }

        return $periods;
    }
}

if (!function_exists('diffForHuman')) {
    /**
     * Get the difference between the given date and now in a human-readable format, with language detection (default: en).
     *
     * @param string $date
     * @param string|null $lang
     * @return string|null
     */
    function diffForHuman($date, $lang = null)
    {
        try {
            if (!$date) {
                return null;
            }
            $lang = $lang ?: (app()->getLocale() ?? 'en');
            return Carbon::parse($date)->locale($lang)->diffForHumans();
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('switchDate')) {
    /**
     * Switch date based on the given slug.
     *
     * @param string $slug
     * @return array
     */
    function switchDate($slug)
    {
        try {
            $dateRanges = [
                'today' => [now(), now(), 'ga:date'],
                'yesterday' => [now()->subDay(1), now()->subDay(1), 'ga:date'],
                'this-week' => [now()->startOfWeek(), now()->endOfWeek(), 'ga:date'],
                'this-month' => [now()->startOfMonth(), now(), 'ga:date'],
                'this-year' => [now()->startOfYear(), now()->endOfYear(), 'ga:month'],
                'last-7-days' => [now()->subDays(6), now(), 'ga:date'],
                'last-30-days' => [now()->subDays(29), now(), 'ga:date'],
                'last-90-days' => [now()->subDays(89), now(), 'ga:date'],
                'one-year' => [now()->subYear(1), now()->endOfYear(), 'ga:yearMonth'],
            ];

            $default = [now()->startOfYear(), now()->endOfYear(), 'ga:month'];

            $dates = $dateRanges[$slug] ?? $default;

            return [
                'startDate' => $dates[0],
                'endDate' => $dates[1],
                'metrics' => $dates[2],
            ];
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('dateTimeTranslated')) {
    /**
     * Translate and format the given date.
     *
     * @param string $date
     * @param string $format
     * @param string $locale
     * @return string|null
     */
    function dateTimeTranslated($date, $format = 'D, d M Y', $locale = 'id')
    {
        try {
            return Carbon::parse($date)->locale($locale)->translatedFormat($format);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('carbon')) {
    /**
     * Parse the given date into a Carbon instance.
     *
     * @param string $date
     * @return Carbon|null
     */
    function carbon($date)
    {
        try {
            return Carbon::parse($date);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('chartMetrics')) {
    /**
     * Generate chart metrics based on the given date range.
     *
     * @param array|null $dates
     * @return array|null
     */
    function chartMetrics(?array $dates)
    {
        try {
            $count = carbon($dates['start'])->diffInDays($dates['end']);
            $metrics = [];
            $periods = CarbonPeriod::create($dates['start'], $dates['end'])->locale('id');

            if ($count <= 7) {
                foreach ($periods as $period) {
                    $metrics[$period->translatedFormat('d M')] = [
                        'start' => $period->toDateString(),
                        'end' => $period->toDateString(),
                    ];
                }
            } elseif ($count <= 31) {
                $metrics = generateMetrics($periods, 7);
            } elseif ($count <= 183) {
                $metrics = generateMetrics($periods, 21);
            } else {
                $periods = CarbonPeriod::create($dates['start'], '1 month', $dates['end'])->locale('id');
                $mapped = collect($periods)->map(fn($period) => ['date' => $period, 'month' => $period->translatedFormat('M')])
                    ->groupBy('month');
                foreach ($mapped as $key => $value) {
                    $date = $value->pluck('date')->first();
                    $metrics[$key] = [
                        'start' => $key == array_key_first($mapped->toArray()) ? $periods->getStartDate()->toDateString() : $date->startOfMonth()->toDateString(),
                        'end' => $key == array_key_last($mapped->toArray()) ? $periods->getEndDate()->toDateString() : $date->endOfMonth()->toDateString(),
                    ];
                }
            }

            return $metrics;
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('chartMetrics')) {
    /**
     * Generate metrics based on the given periods and chunk size.
     *
     * @param CarbonPeriod $periods
     * @param int $chunkSize
     * @return array
     */
    function generateMetrics($periods, $chunkSize)
    {
        $metrics = [];
        // Split the periods into chunks of the specified size
        $chunks = array_chunk($periods->toArray(), $chunkSize);
        foreach ($chunks as $range) {
            $start = array_shift($range);
            $end = end($range);
            // Format the metrics for each chunk
            $metrics[$start->translatedFormat('d M') . ' - ' . $end->translatedFormat('d M')] = [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
            ];
        }
        return $metrics;
    }
}

<?php

use Brick\PhoneNumber\PhoneNumber;
use Illuminate\Support\Collection;
use Modules\Common\Models\Content;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Modules\Panel\Enums\SidebarEnum;
use Illuminate\Support\Facades\Cache;
use Modules\Common\Models\AppSetting;
use Brick\PhoneNumber\PhoneNumberFormat;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Brick\PhoneNumber\PhoneNumberParseException;

if (!function_exists('activeRouteIs')) {
    /**
     * Check route name and get active class name.
     *
     * @param  string|array $routeName
     * @param  string $active
     * @return string
     */
    function activeRouteIs($routeName, $active = 'active'): string
    {
        try {
            if (is_array($routeName)) {
                foreach ($routeName as $route) {
                    if (request()->routeIs($route)) {
                        return $active;
                    }
                }
                return '';
            }
            return request()->routeIs($routeName) ? $active : '';
        } catch (Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('filterCollection')) {
    /**
     * Implement where like in laravel collection
     *
     * @param  collection $collection
     * @param  string $needle
     * @param  string $row
     * @return collection
     */
    function filterCollection($collection, $needle = '', $row = null): Collection
    {
        try {
            if ($collection instanceof Collection) {
                return $collection->filter(function ($data) use ($needle, $row) {
                    return preg_match("/{$needle}/i", $data[$row]);
                });
            }
            throw new Exception('The data given is not a collection.');
        } catch (Exception $exception) {
            return collect();
        }
    }
}

if (!function_exists('paginationInfo')) {
    /**
     * Get pagination info from paginator
     *
     * @param  Paginator $paginator
     * @return string|null
     */
    function paginationInfo($paginator)
    {
        try {
            $firstItem = $paginator->firstItem();
            $lastItem = $paginator->lastItem();

            if (!$firstItem && !$lastItem) {
                return null;
            }

            return 'Menampilkan ' . $firstItem . '-' . $lastItem . ' dari ' . $paginator->total();
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('phone')) {
    /**
     * Remove symbols from phone number
     *
     * @param  string $number
     * @return int
     */
    function phone($number, $region_code = 'ID', $format = 'E164')
    {
        if (!$number) {
            return null;
        }

        try {
            $number = PhoneNumber::parse($number, $region_code);

            switch ($format) {
                case 'INTERNATIONAL':
                    return $number->format(PhoneNumberFormat::INTERNATIONAL);
                case 'NATIONAL':
                    return $number->format(PhoneNumberFormat::NATIONAL);
                case 'RFC3966':
                    return $number->format(PhoneNumberFormat::RFC3966);
                default:
                    return $number->format(PhoneNumberFormat::E164);
            }
        } catch (PhoneNumberParseException $e) {
            return null;
        }
    }
}

if (!function_exists('sortable')) {
    /**
     * Sort order converter
     *
     * @param  string $param
     * @return array
     */
    function sortable($param): array
    {
        try {
            $sortMap = [
                'nama-a-z' => ['sort' => 'name', 'order' => 'asc'],
                'nama-z-a' => ['sort' => 'name', 'order' => 'desc'],
                'harga-rendah-tinggi' => ['sort' => 'price', 'order' => 'asc'],
                'harga-tinggi-rendah' => ['sort' => 'price', 'order' => 'desc']
            ];
            return $sortMap[$param] ?? ['sort' => 'created_at', 'order' => 'desc'];
        } catch (Exception $exception) {
            return ['sort' => 'created_at', 'order' => 'desc'];
        }
    }
}

if (!function_exists('switchOrderStatusToRaw')) {
    /**
     * Convert filter strings order status to raw format
     *
     * @param  string $slug
     * @return string
     */
    function switchOrderStatusToRaw($slug): string
    {
        try {
            $statusMap = [
                'belum-dibayar' => 'PENDING',
                'telah-dibayar' => 'COMPLETE',
                'kadaluarsa' => 'EXPIRED',
                'dibatalkan' => 'CANCEL'
            ];
            return $statusMap[$slug] ?? 'PENDING';
        } catch (Exception $exception) {
            return 'PENDING';
        }
    }
}

if (!function_exists('trim_regexp')) {
    /**
     * Create multiple phrase from string
     *
     * @param  string $keyword
     * @return string
     */
    function trim_regexp($keyword): string
    {
        try {
            $words = array_filter(array_map('trim', explode(' ', $keyword)));
            $patterns = implode('|', $words);
            return $patterns . '|' . trim($keyword);
        } catch (Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('translate')) {
    /**
     * Translate a given text from source language to target language.
     * If source or target is not provided, it will auto-detect from app locale.
     *
     * @param  string $text
     * @param  string|null $source
     * @param  string|null $to
     * @return string
     */
    function translate(string $text, ?string $source = null, ?string $to = null): string
    {
        try {
            // Use app locale if not provided
            $source = $source ?: 'auto';
            $to = $to ?: app()->getLocale();

            // If source and target are the same, return original text
            if ($source !== 'auto' && $source === $to) {
                return $text;
            }

            $tr = new GoogleTranslate($to);
            if ($source !== 'auto') {
                $tr->setSource($source);
            }

            return $tr->translate($text);
        } catch (\Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('getSidebarItems')) {
    /**
     * Get sidebar items based on current route
     *
     * @param  string $currentRoute
     * @param  array $sidebarItems
     * @return array
     */
    function getSidebarItems($currentRoute, $sidebarItems): array
    {
        try {
            // Special case for main panel routes
            if (str_contains($currentRoute, "panel.main")) {
                return $sidebarItems['web'] ?? [];
            }

            // Match group: 'web', 'acl', 'main'
            foreach (SidebarEnum::cases() as $key) {
                if (str_contains($currentRoute, "panel.{$key->value}.")) {
                    return $sidebarItems[$key->value] ?? [];
                }
            }
            return []; // default fallback
        } catch (Exception $exception) {
            return [];
        }
    }
}

if (!function_exists('getContent')) {
    /**
     * Get a content column value by key, using cache and fallback to DB.
     *
     * @param string $key
     * @param string $column
     * @param mixed $default
     * @return mixed
     */
    function getContent(string $key, string $column = 'value', mixed $default = null): mixed
    {
        $cacheKey = "content:{$key}";

        $cached = cache($cacheKey);

        // Return cached value, json-decode when input_type is json and column is 'value'
        if ($cached && is_array($cached) && array_key_exists($column, $cached)) {
            if (
                $column === 'value'
                && (isset($cached['input_type']) && $cached['input_type'] === 'json')
                && is_string($cached['value'])
            ) {
                $decoded = json_decode($cached['value'], true);
                return $decoded !== null ? $decoded : $default;
            }
            return $cached[$column];
        }

        // Check if table exists before querying
        if (!\Illuminate\Support\Facades\Schema::hasTable((new \Modules\Common\Models\Content)->getTable())) {
            return $default;
        }

        // Optional fallback logic: try DB if not in cache
        $content = Content::where('key', $key)->first();
        if ($content) {
            // Optionally cache all columns now
            $cacheData = [
                'name' => $content->name,
                'value' => $content->value,
                'type' => $content->type,
                'input_type' => $content->input_type,
                'meta' => $content->meta,
            ];
            Cache::put($cacheKey, $cacheData);
            if (
                $column === 'value'
                && (isset($content->input_type) && $content->input_type === 'json')
                && is_string($content->value)
            ) {
                $decoded = json_decode($content->value, true);
                return $decoded !== null ? $decoded : $default;
            }
            return $content->{$column} ?? $default;
        }

        return $default;
    }
}

if (!function_exists('getSetting')) {
    /**
     * Get an app setting column value by key, using cache and fallback to DB.
     *
     * @param string $key
     * @param string $column
     * @param mixed $default
     * @return mixed
     */
    function getSetting(string $key, string $column = 'value', mixed $default = null): mixed
    {
        $cacheKey = "app_setting:{$key}";

        $cached = cache($cacheKey);

        // Return cached value, json-decode when type is json and column is 'value'
        if ($cached && is_array($cached) && array_key_exists($column, $cached)) {
            if (
                $column === 'value'
                && (isset($cached['type']) && $cached['type'] === 'json')
                && is_string($cached['value'])
            ) {
                $decoded = json_decode($cached['value'], true);
                return $decoded !== null ? $decoded : $default;
            }
            return $cached[$column];
        }

        // Check if table exists before querying
        if (!\Illuminate\Support\Facades\Schema::hasTable((new \Modules\Common\Models\AppSetting)->getTable())) {
            return $default;
        }

        // Optional fallback logic: try DB if not in cache
        $setting = AppSetting::where('key', $key)->first();
        if ($setting) {
            // Optionally cache all columns now
            $cacheData = [
                'name' => $setting->name,
                'value' => $setting->value,
                'group' => $setting->group,
                'type' => $setting->type,
                'meta' => $setting->meta,
            ];
            Cache::put($cacheKey, $cacheData);
            if (
                $column === 'value'
                && (isset($setting->type) && $setting->type === 'json')
                && is_string($setting->value)
            ) {
                $decoded = json_decode($setting->value, true);
                return $decoded !== null ? $decoded : $default;
            }
            return $setting->{$column} ?? $default;
        }

        return $default;
    }
}

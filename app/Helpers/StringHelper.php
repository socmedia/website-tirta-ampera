<?php

use Illuminate\Support\Str;

if (!function_exists('slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     * If the slug already exists, it will append a number to make it unique.
     *
     * @param string $string
     * @param string $model
     * @param string $column
     * @return string
     */
    function slug($string, $model = null, $column = 'slug'): string
    {
        try {
            $baseSlug = Str::slug($string);
            $slug = $baseSlug;
            $counter = 1;

            // If model is provided, check for existing slugs
            if ($model && class_exists($model)) {
                while ($model::where($column, $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            } else {
                // Fallback to timestamp if no model provided
                $slug = $baseSlug . '-' . now()->format('u');
            }

            return $slug;
        } catch (Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('unSlug')) {
    /**
     * Convert a slug back to a string with spaces.
     *
     * @param string $slug
     * @return string
     */
    function unSlug($slug): string
    {
        try {
            return str_replace(['_', '-'], ' ', $slug);
        } catch (Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('xssFilter')) {
    /**
     * Remove any <script> tags from the given text to prevent XSS.
     *
     * @param string $text
     * @return string
     */
    function xssFilter($text): string
    {
        try {
            return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $text);
        } catch (Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('title')) {
    /**
     * Convert the given text to title case.
     *
     * @param string $text
     * @return string|null
     */
    function title($text): ?string
    {
        try {
            return Str::title($text);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('randAlpha')) {
    /**
     * Generate a random string of alphabetic characters of the given length.
     *
     * @param int $length
     * @return string|null
     */
    function randAlpha($length = 6): ?string
    {
        try {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($characters), 0, $length);
        } catch (Exception $exception) {
            return null;
        }
    }
}

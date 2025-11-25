<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('user')) {
    /**
     * Get authenticated user or specific user column
     *
     * @param string|null $column Column name to retrieve
     * @param string $guard Authentication guard name
     * @return mixed User instance, column value, or null
     */
    function user($column = null, $guard = 'web')
    {
        try {
            $user = auth($guard)->user();
            return $user && $column ? $user->$column : $user;
        } catch (\Exception $e) {
            Log::error('Error in user helper: ' . $e->getMessage());
            return null;
        }
    }
}

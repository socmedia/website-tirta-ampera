<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * Update the existing cache using the Laravel cache driver.
     *
     * @param  string|null $key The cache key to update.
     * @param  mixed $value The value to store in the cache.
     * @return void
     */
    public function updateCache(?string $key, mixed $value)
    {
        Cache::forget($key);
        Cache::forever($key, $value);
    }

    /**
     * Remove a single cache entry using the Laravel cache driver.
     *
     * @param  string|null $key The cache key to remove.
     * @return void
     */
    public function removeCache(?string $key)
    {
        Cache::forget($key);
    }

    /**
     * Remove multiple cache entries using the Laravel cache driver.
     *
     * @param  array|null $keys An array of cache keys to remove.
     * @return void
     */
    public function removeCaches(?array $keys)
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}

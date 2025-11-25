<?php

namespace Modules\Common\Observers;

use App\Traits\Cacheable;
use Modules\Common\Models\Content;

class ContentObserver
{
    use Cacheable;

    /**
     * Generate the cache key for the given Content.
     *
     * @param  \Modules\Common\Models\Content  $content
     * @return string|null
     */
    protected function getCacheKey(Content $content): ?string
    {
        if (!$content || !$content->key) {
            return null;
        }
        return "content:{$content->key}";
    }

    /**
     * Get the cache value for the given Content.
     *
     * @param  \Modules\Common\Models\Content  $content
     * @return array|null
     */
    protected function getCacheValue(Content $content): ?array
    {
        if (!$content) {
            return null;
        }
        return [
            'name'         => $content->name,
            'value'        => $content->value,
            'page'         => $content->page,
            'section'      => $content->section,
            'key'          => $content->key,
            'type'         => $content->type,
            'input_type'   => $content->input_type,
            'meta'         => $content->meta,
            'created_at'   => $content->created_at,
            'updated_at'   => $content->updated_at,
        ];
    }

    /**
     * Handle the Content "created" event.
     */
    public function created(Content $content): void
    {
        $cacheKey = $this->getCacheKey($content);
        $cacheValue = $this->getCacheValue($content);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the Content "updated" event.
     */
    public function updated(Content $content): void
    {
        $cacheKey = $this->getCacheKey($content);
        $cacheValue = $this->getCacheValue($content);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the Content "deleted" event.
     */
    public function deleted(Content $content): void
    {
        $cacheKey = $this->getCacheKey($content);
        if ($cacheKey) {
            $this->removeCache($cacheKey);
        }
    }

    /**
     * Handle the Content "restored" event.
     */
    public function restored(Content $content): void
    {
        $cacheKey = $this->getCacheKey($content);
        $cacheValue = $this->getCacheValue($content);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the Content "force deleted" event.
     */
    public function forceDeleted(Content $content): void
    {
        $cacheKey = $this->getCacheKey($content);
        if ($cacheKey) {
            $this->removeCache($cacheKey);
        }
    }
}

<?php

namespace Modules\Common\Observers;

use App\Traits\Cacheable;
use Modules\Common\Models\AppSetting;

class AppSettingObserver
{
    use Cacheable;

    /**
     * Generate the cache key for the given AppSetting.
     *
     * @param  \Modules\Common\Models\AppSetting  $appSetting
     * @return string|null
     */
    protected function getCacheKey(AppSetting $appSetting): ?string
    {
        if (!$appSetting || !$appSetting->key) {
            return null;
        }
        return "app_setting:{$appSetting->key}";
    }

    /**
     * Get the cache value for the given AppSetting.
     *
     * @param  \Modules\Common\Models\AppSetting  $appSetting
     * @return array|null
     */
    protected function getCacheValue(AppSetting $appSetting): ?array
    {
        if (!$appSetting) {
            return null;
        }
        return [
            'name' => $appSetting->name,
            'value' => $appSetting->value,
            'group' => $appSetting->group,
            'type' => $appSetting->type,
            'meta' => $appSetting->meta,
        ];
    }

    /**
     * Handle the AppSetting "created" event.
     */
    public function created(AppSetting $appSetting): void
    {
        $cacheKey = $this->getCacheKey($appSetting);
        $cacheValue = $this->getCacheValue($appSetting);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the AppSetting "updated" event.
     */
    public function updated(AppSetting $appSetting): void
    {
        $cacheKey = $this->getCacheKey($appSetting);
        $cacheValue = $this->getCacheValue($appSetting);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the AppSetting "deleted" event.
     */
    public function deleted(AppSetting $appSetting): void
    {
        $cacheKey = $this->getCacheKey($appSetting);
        if ($cacheKey) {
            $this->removeCache($cacheKey);
        }
    }

    /**
     * Handle the AppSetting "restored" event.
     */
    public function restored(AppSetting $appSetting): void
    {
        $cacheKey = $this->getCacheKey($appSetting);
        $cacheValue = $this->getCacheValue($appSetting);
        if ($cacheKey && $cacheValue) {
            $this->updateCache($cacheKey, $cacheValue);
        }
    }

    /**
     * Handle the AppSetting "force deleted" event.
     */
    public function forceDeleted(AppSetting $appSetting): void
    {
        $cacheKey = $this->getCacheKey($appSetting);
        if ($cacheKey) {
            $this->removeCache($cacheKey);
        }
    }
}

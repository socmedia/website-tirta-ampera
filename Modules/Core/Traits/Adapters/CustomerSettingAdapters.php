<?php

namespace Modules\Core\Traits\Adapters;

trait CustomerSettingAdapters
{
    /**
     * Get the setting value for a specific key.
     *
     * @param string $key The key of the setting.
     * @return mixed The value of the setting or null if not found.
     */
    public function getValue($key)
    {
        $setting = $this->settings()->where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : null;
    }
}

<?php

namespace Modules\Core\Traits\Adapters;

trait VendorSettingAdapters
{
    /**
     * Get the setting value for a specific key.
     *
     * @param string $key The key of the setting.
     * @return mixed The value of the setting or null if not found.
     */
    public function getValue($key)
    {
        $setting = $this->vendorSettings()->where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : null;
    }
}

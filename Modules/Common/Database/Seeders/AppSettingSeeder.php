<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\AppSetting;
use App\Traits\Cacheable;

class AppSettingSeeder extends Seeder
{
    use Cacheable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = array_merge(
            self::fromJson('settings.general.json'),
            self::fromJson('settings.contact.json'),
            self::fromJson('settings.social.json'),
            self::fromJson('settings.integration.json')
            // Add more as needed, e.g. self::fromJson('settings.ecommerce.json')
        );

        foreach ($settings as $setting) {
            // 'translations' column and table are dropped, so remove reference
            unset($setting['translations']);

            // Ensure 'meta' is a string (JSON) or null before insert
            if (isset($setting['meta']) && is_array($setting['meta'])) {
                $setting['meta'] = !empty($setting['meta']) ? json_encode($setting['meta']) : null;
            }

            // Insert AppSetting row
            AppSetting::insert($setting);
        }
    }

    /**
     * Format helper for AppSetting.
     */
    protected static function setting(
        string $group,
        string $key,
        string $type,
        ?string $name = null,
        ?string $value = null,
        array $meta = []
    ): array {
        return [
            'group' => $group,
            'key' => $key,
            'type' => $type,
            'meta' => $meta,
            'name' => $name,
            'value' => $value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generic loader for appsetting JSON files.
     */
    public static function fromJson(string $filename): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/settings/' . $filename);
        $json     = file_get_contents($jsonPath);
        $items    = json_decode($json, true);

        return $items ?? [];
    }
}

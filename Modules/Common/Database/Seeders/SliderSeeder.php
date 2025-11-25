<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Enums\SliderType;
use Modules\Common\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders = array_merge(
            self::fromJson('sliders.hero.json'),
            self::fromJson('sliders.promo.json'),
            self::fromJson('sliders.milestone.json'),
            self::fromJson('sliders.team.json'),
        );

        foreach ($sliders as $sliderData) {
            Slider::insert($sliderData);
        }
    }

    /**
     * Helper to load and normalize slider data from a JSON file.
     *
     * @param string $filename
     * @return array
     */
    protected static function fromJson(string $filename): array
    {
        $now = now();
        $path = base_path('Modules/Common/Database/Seeders/json/sliders/' . $filename);

        if (!file_exists($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $sliders = json_decode($json, true);

        foreach ($sliders as &$slider) {
            // Assign all columns only present in the sliders table, NO TRANSLATION
            // Columns per migration: heading, sub_heading, description, alt, type, desktop_media_path, mobile_media_path,
            // sort_order, status, meta, created_by, updated_by, deleted_at (auto), created_at, updated_at (timestamps)

            $slider['created_at'] = $slider['created_at'] ?? $now;
            $slider['updated_at'] = $slider['updated_at'] ?? $now;

            // Normalize type to lowercase string or fallback to filename
            if (isset($slider['type'])) {
                $slider['type'] = strtolower($slider['type']);
            } else {
                if (str_contains($filename, 'hero')) {
                    $slider['type'] = SliderType::HERO;
                } elseif (str_contains($filename, 'promo')) {
                    $slider['type'] = SliderType::PROMOTION;
                } elseif (str_contains($filename, 'milestone')) {
                    $slider['type'] = SliderType::MILESTONE;
                } elseif (str_contains($filename, 'stores')) {
                    $slider['type'] = 'stores';
                }
            }

            // meta column should be JSON or null
            if (isset($slider['meta']) && is_array($slider['meta'])) {
                $slider['meta'] = !empty($slider['meta']) ? json_encode($slider['meta']) : null;
            }

            // Remove any translation keys if present in JSON
            unset($slider['translations']);
        }
        unset($slider);

        return $sliders;
    }
}

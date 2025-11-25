<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Models\Content;

class SeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seoFiles = [
            'seo.homepage.json',
            'seo.about.json',
            'seo.contact.json',
            'seo.news.json',
            'seo.terms-conditions.json',
            'seo.privacy-policy.json',
        ];

        $seos = [];
        foreach ($seoFiles as $file) {
            $seos = array_merge($seos, self::fromJson($file));
        }

        // Insert into the contents table, matching only the new contents columns (no translations)
        foreach ($seos as $seoData) {
            Content::insert($seoData);
        }
    }

    /**
     * Helper to load and normalize SEO data from a JSON file.
     *
     * @param string $filename
     * @return array
     */
    protected static function fromJson(string $filename)
    {
        $now = now();
        $path = base_path('Modules/Common/Database/Seeders/json/seo/' . $filename);

        if (!file_exists($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $items = json_decode($json, true);

        $result = [];
        foreach ($items as $item) {
            // Match columns as per new contents schema, no translations, no translatable column, no legacy fields
            $result[] = [
                'page'       => $item['page'] ?? (explode('.', $item['key'])[0] ?? null),
                'section'    => $item['section'] ?? null,
                'key'        => $item['key'],
                'name'       => $item['name'] ?? null,
                'value'      => $item['value'] ?? null,
                'type'       => 'seo',
                'input_type' => $item['input_type'] ?? 'input:text',
                'meta'       => !empty($item['meta']) ? json_encode($item['meta']) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        return $result;
    }
}

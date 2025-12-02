<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Enums\ContentType;
use Modules\Common\Models\Content;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List all page JSON files to import, easy to add more if needed
        $jsonFiles = [
            'page.privacy_policy.json',
            'page.terms_and_conditions.json',
            'pages.group.json',
            'pages.prohibition.json',
            'pages.rights_obligation.json',
            'pages.tariff.json',
        ];

        $contents = [];
        foreach ($jsonFiles as $file) {
            $contents = array_merge($contents, self::fromJson($file));
        }

        // Insert all content entries efficiently
        foreach ($contents as $content) {
            Content::insert($content);
        }
    }

    /**
     * Read content definition(s) from a JSON file and format for database.
     */
    protected static function fromJson(string $file): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/pages/' . $file);
        if (!is_file($jsonPath)) {
            return [];
        }
        $json = file_get_contents($jsonPath);
        $items = json_decode($json, true);

        $results = [];
        foreach ($items as $item) {
            $results[] = self::content(
                $item['key'] ?? null,
                $item['input_type'] ?? 'input:text',
                $item['meta'] ?? [],
                $item['page'] ?? null,
                $item['section'] ?? null,
                $item['name'] ?? null,
                $item['value'] ?? null,
                $item['type'] ?? null
            );
        }
        return $results;
    }

    /**
     * Format helper for main content (no translations).
     */
    protected static function content(
        ?string $key,
        string $inputType = 'input:text',
        array $meta = [],
        ?string $page = null,
        ?string $section = null,
        ?string $name = null,
        ?string $value = null,
        ?string $type = null
    ): array {
        // Defensive: key is REQUIRED. If missing, return empty array.
        if (!$key) {
            return [];
        }
        // If page is not provided, infer from key (before first dot)
        if ($page === null) {
            $page = explode('.', $key, 2)[0];
        }
        // If section is not provided, infer from key (second part if exists)
        if ($section === null) {
            $parts   = explode('.', $key, 3);
            $section = $parts[1] ?? null;
        }
        return [
            'page'            => $page,
            'section'         => $section,
            'key'             => $key,
            'name'            => $name,
            'value'           => $value,
            'type'            => $type ?? ContentType::STATIC_PAGE,
            'input_type'      => $inputType,
            'meta'            => !empty($meta) ? json_encode($meta) : null,
            'created_at'      => now(),
            'updated_at'      => now(),
        ];
    }
}

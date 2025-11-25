<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Models\Content;

class ContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = array_merge(
            self::fromJson('content.about.json'),
            self::fromJson('content.contact.json'),
            self::fromJson('content.homepage.json'),
            self::fromJson('content.service.json'),
            self::fromJson('content.global.json'),
            self::fromJson('content.news.json'),
            self::fromJson('content.page.json'),
        );

        // Insert contents (no translations - not translatable anymore)
        foreach ($contents as $content) {
            Content::insert($content);
        }
    }

    /**
     * Format helper for main content.
     */
    protected static function content(
        string $key,
        string $inputType,
        array $meta = [],
        ?string $page = null,
        ?string $section = null,
        ?string $name = null,
        mixed $value = null,
        string $type = 'content'
    ): array {
        // If page is not provided, infer from key (before first dot)
        if ($page === null) {
            $page = explode('.', $key, 2)[0];
        }
        // If section is not provided, infer from key (second part if exists)
        if ($section === null) {
            $parts   = explode('.', $key, 3);
            $section = $parts[1] ?? null;
        }

        // Check if input_type indicates JSON, and encode value if so
        $finalValue = $value;
        if ($inputType === 'json' && $value !== null && !is_string($value)) {
            $finalValue = json_encode($value);
        }

        return [
            'page'            => $page,
            'section'         => $section,
            'key'             => $key,
            'name'            => $name,
            'value'           => $finalValue,
            'type'            => $type,      // static_page, content, seo, etc.
            'input_type'      => $inputType, // input:checkbox, input:email, input:image, input:number, input:text, input:url, json, textarea
            'meta'            => $meta ? json_encode($meta) : null,
            'created_at'      => now(),
            'updated_at'      => now(),
        ];
    }

    /**
     * Generic loader for content JSON files.
     * Now expects each item to have key, input_type, name, value, meta, page, section, type.
     */
    public static function fromJson(string $filename): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/contents/' . $filename);
        $json     = file_get_contents($jsonPath);
        $items    = json_decode($json, true);

        $result = [];
        foreach ($items as $item) {
            $result[] = self::content(
                $item['key'],
                $item['input_type'],
                $item['meta'] ?? [],
                $item['page'] ?? null,
                $item['section'] ?? null,
                $item['name'] ?? null,
                $item['value'] ?? null,
                $item['type'] ?? 'content'
            );
        }
        return $result;
    }
}

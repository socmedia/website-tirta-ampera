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
        $contents = array_merge(
            self::privacyPolicy(),
            self::termsAndConditions(),
        );

        // Insert contents (no translations, not translatable anymore, match table columns)
        foreach ($contents as $content) {
            Content::insert($content);
        }
    }

    /**
     * Format helper for main content (no translations).
     */
    protected static function content(
        string $key,
        string $inputType = 'input:text',
        array $meta = [],
        ?string $page = null,
        ?string $section = null,
        ?string $name = null,
        ?string $value = null,
        ?string $type = null
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
        return [
            'page'            => $page,
            'section'         => $section,
            'key'             => $key,
            'name'            => $name,
            'value'           => $value,
            'type'            => $type ?? ContentType::STATIC_PAGE,
            'input_type'      => $inputType,
            // The contents table expects JSON for 'meta', or null
            'meta'            => !empty($meta) ? json_encode($meta) : null,
            'created_at'      => now(),
            'updated_at'      => now(),
        ];
    }

    public static function privacyPolicy(): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/pages/page.privacy_policy.json');
        $json = file_get_contents($jsonPath);
        $items = json_decode($json, true);

        $result = [];
        foreach ($items as $item) {
            $result[] = self::content(
                $item['key'],
                $item['input_type'] ?? 'input:text',
                $item['meta'] ?? [],
                $item['page'] ?? null,
                $item['section'] ?? null,
                $item['name'] ?? null,
                $item['value'] ?? null,
                $item['type'] ?? null
            );
        }
        return $result;
    }

    public static function termsAndConditions(): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/pages/page.terms_and_conditions.json');
        $json = file_get_contents($jsonPath);
        $items = json_decode($json, true);

        $result = [];
        foreach ($items as $item) {
            $result[] = self::content(
                $item['key'],
                $item['input_type'] ?? 'input:text',
                $item['meta'] ?? [],
                $item['page'] ?? null,
                $item['section'] ?? null,
                $item['name'] ?? null,
                $item['value'] ?? null,
                $item['type'] ?? null
            );
        }
        return $result;
    }
}

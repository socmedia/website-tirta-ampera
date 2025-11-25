<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\Category;
use Modules\Common\Models\Faq;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = self::faqs();

        // Insert faqs
        foreach ($faqs as $faq) {
            Faq::insert($faq);
        }
    }

    /**
     * Format helper for faq.
     */
    protected static function content(
        ?int $categoryId,
        ?string $question,
        ?string $slug,
        ?string $answer,
        int $sortOrder,
        int $featured,
        int $status,
    ): array {
        return [
            'category_id' => $categoryId,
            'question' => $question,
            'slug' => $slug,
            'answer' => $answer,
            'sort_order' => $sortOrder,
            'featured' => $featured,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public static function faqs(): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/faq.json');
        $json = file_get_contents($jsonPath);
        $items = json_decode($json, true);

        // Get categories by name only, no translations involved
        $categoryNames = [
            'Umum',
            'Investor & Keuangan',
            'Informasi Investor',
        ];

        $categories = Category::group('faqs')->whereIn('name', $categoryNames)->get();

        $result = [];
        foreach ($items as $i => $item) {
            $category = $categories->where('name', $item['category'])->first();

            $result[] = self::content(
                $category ? $category->id : null,
                $item['question'] ?? null,
                $item['slug'] ?? null,
                $item['answer'] ?? null,
                $item['sort_order'] ?? 0,
                $item['featured'] ?? 0,
                $item['status'] ?? 1,
            );
        }
        return $result;
    }
}

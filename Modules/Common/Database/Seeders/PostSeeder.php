<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Models\Category;
use Modules\Common\Models\Post;
use Modules\Core\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: seed random posts for testing (remove if not needed)
        // Post::factory()->count(100)->create();

        // Insert news from JSON
        $news = self::fromJson();

        foreach ($news as $item) {
            Post::create($item);
        }
    }

    /**
     * Get news data from a JSON file.
     *
     * @return array
     */
    protected static function fromJson(): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/news.json');

        if (!file_exists($jsonPath)) {
            return [];
        }

        $json = file_get_contents($jsonPath);
        $newsRaw = json_decode($json, true);

        $news = [];

        foreach ($newsRaw as $item) {
            $category = $item['category_id'] ?? null;
            $authorName = 'Super Admin';

            $findCategory = null;
            if ($category) {
                $findCategory = Category::where('name', $category)
                    ->where('group', 'posts')
                    ->first();
            }

            $user = User::where('name', $authorName)->first();

            $news[] = [
                'title' => $item['title'] ?? '',
                'slug' => $item['slug'] ?? '',
                'subject' => $item['subject'] ?? null,
                'content' => $item['content'] ?? null,
                'meta_title' => $item['meta_title'] ?? null,
                'meta_description' => $item['meta_description'] ?? null,
                'category_id' => $findCategory?->id,
                'type' => $item['type'] ?? 'blog',
                'thumbnail' => $item['thumbnail'] ?? '',
                'tags' => isset($item['tags']) ? (is_array($item['tags']) ? implode(',', $item['tags']) : $item['tags']) : null,
                'reading_time' => $item['reading_time'] ?? null,
                'number_of_views' => $item['number_of_views'] ?? 0,
                'number_of_shares' => $item['number_of_shares'] ?? 0,
                'author' => $user?->id,
                'published_by' => $user?->id,
                'published_at' => isset($item['published_at']) ? carbon($item['published_at']) : null,
                'archived_at' => $item['archived_at'] ?? null,
                'created_at' => isset($item['created_at']) ? carbon($item['created_at']) : now(),
                'updated_at' => isset($item['updated_at']) ? carbon($item['updated_at']) : now(),
                'deleted_at' => $item['deleted_at'] ?? null,
            ];
        }

        return $news;
    }
}

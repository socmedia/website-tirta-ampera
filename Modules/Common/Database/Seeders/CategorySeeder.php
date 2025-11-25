<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Modules\Common\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'faqs' => self::fromJson('category.faqs.json'),
            'notifications' => self::fromJson('category.notifications.json'),
            'posts' => self::fromJson('category.posts.json'),
        ];

        foreach ($groups as $key => $group) {
            foreach ($group as $categoryData) {
                Category::create($categoryData);
            }

            $categories = Category::where('group', $key)->orderBy('sort_order', 'asc')->get();
            Cache::put('category:' . $key, $categories, now()->addDay());
        }
    }

    /**
     * Format helper for category (no translations).
     */
    protected static function content(
        ?string $parent,
        string $name,
        string $slug,
        ?string $description,
        ?string $imagePath,
        ?string $icon,
        ?int $parentId,
        ?int $sortOrder,
        bool $status,
        bool $featured,
        ?string $group,
        ?string $createdBy = null,
        ?string $updatedBy = null
    ): array {
        // Parent detection by name if $parent supplied
        if ($parent && !$parentId) {
            $parentObj = Category::where('name', $parent)->first();
            $parentId = $parentObj ? $parentObj->id : null;
        }

        return [
            'parent_id'    => $parentId,
            'name'         => $name,
            'slug'         => $slug,
            'description'  => $description,
            'image_path'   => $imagePath,
            'icon'         => $icon,
            'sort_order'   => $sortOrder,
            'status'       => $status,
            'featured'     => $featured,
            'group'        => $group,
            'created_by'   => $createdBy,
            'updated_by'   => $updatedBy,
            'created_at'   => now()->toDateTimeString(),
            'updated_at'   => now()->toDateTimeString(),
        ];
    }

    /**
     * Generic loader for category JSON files (no translations).
     * Expected JSON:
     * [
     *   [
     *     {
     *       "parent": null,
     *       "name": "...",
     *       "slug": "...",
     *       "description": "...",
     *       "image_path": "...",
     *       "icon": "...",
     *       "parent_id": null,
     *       "sort_order": ...,
     *       "status": ...,
     *       "featured": ...,
     *       "group": "...",
     *       "created_by": "...",
     *       "updated_by": "..."
     *     },
     *     ...
     *   ],
     *   ...
     * ]
     */
    public static function fromJson(string $filename): array
    {
        $jsonPath = base_path('Modules/Common/Database/Seeders/json/categories/' . $filename);
        $json     = file_get_contents($jsonPath);
        $items    = json_decode($json, true);

        $result = [];
        foreach ($items as $item) {
            foreach ($item as $category) {
                $result[] = self::content(
                    $category['parent']        ?? null,
                    $category['name']          ?? '',
                    $category['slug']          ?? '',
                    $category['description']   ?? null,
                    $category['image_path']    ?? null,
                    $category['icon']          ?? null,
                    $category['parent_id']     ?? null,
                    $category['sort_order']    ?? null,
                    $category['status']        ?? true,
                    $category['featured']      ?? false,
                    $category['group']         ?? null,
                    $category['created_by']    ?? null,
                    $category['updated_by']    ?? null
                );
            }
        }

        return $result;
    }
}

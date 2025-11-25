<?php

namespace Modules\Common\Database\Factories;

use Illuminate\Support\Str;
use Modules\Core\Models\User;
use Modules\Common\Enums\PostType;
use Modules\Common\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Common\Models\Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $user = User::where('email', 'developer@app.com')->first();
        $categories = Category::group('posts')->get();

        // Generate a random image using picsum.photos with a unique seed
        $randomImageSeed = $this->faker->unique()->randomNumber();
        $thumbnail = "https://picsum.photos/seed/{$randomImageSeed}/640/480";

        // Columns according to posts table migration (no translation table)
        $title = $this->faker->sentence;
        $slug = Str::slug($title) . '-' . $this->faker->unique()->randomNumber();

        return [
            'title' => $title,
            'slug' => $slug,
            'subject' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(5, true),
            'meta_title' => $this->faker->optional()->sentence,
            'meta_description' => $this->faker->optional()->paragraph,
            'category_id' => $categories->isNotEmpty() ? $categories->random()->id : null,
            'type' => $this->faker->randomElement(PostType::list()),
            'thumbnail' => $thumbnail,
            'tags' => implode(',', $this->faker->words(3)),
            'reading_time' => $this->faker->numberBetween(1, 10) . ' min',
            'number_of_views' => $this->faker->numberBetween(0, 1000),
            'number_of_shares' => $this->faker->numberBetween(0, 100),
            'author' => $user ? $user->id : null,
            'published_by' => $user ? $user->id : null,
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'archived_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}

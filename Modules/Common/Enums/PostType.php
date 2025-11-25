<?php

namespace Modules\Common\Enums;

use Modules\Panel\Http\Controllers\Website\PostController;

enum PostType: string
{
    case BLOG = 'blog';
    case NEWS = 'news';
    case ARTICLE = 'article';

    /**
     * Get list of all post type values
     *
     * @return array<string>
     */
    public static function list(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display name for the post type
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::BLOG => __(ucfirst('blog')),
            self::NEWS => __(ucfirst('news')),
            self::ARTICLE => __(ucfirst('article')),
        };
    }

    /**
     * Get the route prefix for the post type
     *
     * @return string
     */
    public function routePrefix(): string
    {
        return match ($this) {
            self::BLOG => 'blog',
            self::NEWS => 'news',
            self::ARTICLE => 'article',
        };
    }

    /**
     * Get the controller class for the post type
     *
     * @return string
     */
    public function controller(): string
    {
        // You can adjust the namespace as needed
        return match ($this) {
            self::BLOG, self::NEWS, self::ARTICLE =>
            PostController::class,
        };
    }
}

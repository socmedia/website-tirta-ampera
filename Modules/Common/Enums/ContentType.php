<?php

namespace Modules\Common\Enums;

enum ContentType: string
{
    case STATIC_PAGE = 'static_page';
    case CONTENT = 'content';
    case SEO = 'seo';

    /**
     * Get a human-readable label for each content type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::STATIC_PAGE => 'Static Page',
            self::CONTENT => 'Content',
            self::SEO => 'SEO',
        };
    }

    /**
     * Returns a list of all content type values (for selection lists).
     *
     * @return array<string>
     */
    public static function list(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Returns an array of value-label pairs for dropdowns.
     *
     * @return array<int, array{value: string, label: string}>
     */
    public static function toSelectArray(): array
    {
        return array_map(fn(self $type) => [
            'value' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }
}
<?php

namespace Modules\Common\Enums;

enum SliderType: string
{
    case HERO = 'hero';
    case PROMOTION = 'promotion';
    case TESTIMONIAL = 'testimonial';
    case MILESTONE = 'milestone';

    /**
     * Get list of all slider type values
     *
     * @return array<string>
     */
    public static function list(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display name for the slider type
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::HERO => __('Hero'),
            self::PROMOTION => __('Promotion'),
            self::TESTIMONIAL => __('Testimonial'),
            self::MILESTONE => __('Milestone'),
        };
    }

    /**
     * Generate meta information for the slider type.
     *
     * @return array<string, mixed>
     */
    public function meta(): array
    {
        return match ($this) {
            self::HERO => [
                'icon' => 'bx bx-star',
                'description' => __('Main hero slider for homepage'),
                'ratio' => self::HERO->aspectRatio(),
            ],
            self::PROMOTION => [
                'icon' => 'bx bx-purchase-tag',
                'description' => __('Promotion slider for campaigns'),
                'ratio' => self::PROMOTION->aspectRatio(),
            ],
            self::TESTIMONIAL => [
                'icon' => 'bx bx-user-voice',
                'description' => __('Testimonial slider for customer feedback'),
                'ratio' => self::TESTIMONIAL->aspectRatio(),
            ],
            self::MILESTONE => [
                'icon' => 'bx bx-flag',
                'description' => __('Milestone/timeline slider for company history'),
                'ratio' => self::MILESTONE->aspectRatio(),
            ],
        };
    }

    /**
     * Get the aspect ratio string for the slider type.
     *
     * @return string|null
     */
    public function aspectRatio(): ?string
    {
        return match ($this) {
            self::HERO => '16/9',
            self::PROMOTION => '3/2',
            self::TESTIMONIAL => '1/1',
            self::MILESTONE => '4/3',
            default => null,
        };
    }

    /**
     * Get all info for the slider type (value, label, meta)
     *
     * @return array<string, mixed>
     */
    public function info(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label(),
            ...$this->meta(),
        ];
    }
}

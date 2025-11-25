<?php

namespace Modules\Common\Enums;

enum ContentMetaType: string
{
    case BUTTON = 'button';
    case LINK = 'link';
    case IMAGE = 'image';
    case STYLE = 'style';
    case VIDEO = 'video';
    case CUSTOM = 'custom';

    /**
     * Get the fields required for each content meta type
     *
     * @return array<string, string> Array of field names and their types
     */
    public function fields(): array
    {
        return match ($this) {
            self::BUTTON => [
                'text' => 'string',
                'action' => 'string',  // Can be route name or URL
                'class' => 'string|null',
                'type' => 'string', // e.g. 'primary', 'outline'
            ],
            self::LINK => [
                'text' => 'string',
                'url' => 'string',
                'class' => 'string|null',
                'target' => 'string|null', // _blank, _self
            ],
            self::IMAGE => [
                'url' => 'string',
                'alt' => 'string|null',
                'class' => 'string|null',
            ],
            self::STYLE => [
                'text_color' => 'string|null',
                'background_color' => 'string|null',
                'custom_class' => 'string|null',
            ],
            self::VIDEO => [
                'url' => 'string',
                'autoplay' => 'boolean',
                'loop' => 'boolean',
                'muted' => 'boolean',
            ],
            self::CUSTOM => [],
        };
    }

    /**
     * Get list of all content meta type values
     *
     * @return array<string>
     */
    public static function list(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display name for the content meta type
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::BUTTON => 'Button',
            self::LINK => 'Link',
            self::IMAGE => 'Image',
            self::STYLE => 'Style',
            self::VIDEO => 'Video',
            self::CUSTOM => 'Custom',
        };
    }

    /**
     * Check if the content meta type requires a URL field
     *
     * @return bool
     */
    public function requiresUrl(): bool
    {
        return in_array($this, [self::LINK, self::IMAGE, self::VIDEO]);
    }

    /**
     * Get the default values for the content meta type
     *
     * @return array<string, mixed>
     */
    public function defaultValues(): array
    {
        return match ($this) {
            self::VIDEO => [
                'autoplay' => false,
                'loop' => false,
                'muted' => false,
            ],
            self::LINK => [
                'target' => '_self',
            ],
            default => [],
        };
    }

    /**
     * Validate if the provided data matches the required fields
     *
     * @param array<string, mixed> $data
     * @return bool
     */
    public function validateData(array $data): bool
    {
        $requiredFields = array_filter($this->fields(), fn($type) => !str_contains($type, 'null'));
        return empty(array_diff_key($requiredFields, $data));
    }
}

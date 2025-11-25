<?php

namespace Modules\Common\Enums;

enum SettingType: string
{
    case INPUT_CHECKBOX = 'input:checkbox';
    case INPUT_EMAIL = 'input:email';
    case INPUT_IMAGE = 'input:image';
    case INPUT_NUMBER = 'input:number';
    case INPUT_TEXT = 'input:text';
    case INPUT_URL = 'input:url';
    case JSON = 'json';
    case TEXTAREA = 'textarea';

    /**
     * Get a human-readable label for each setting type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::INPUT_CHECKBOX => 'Checkbox',
            self::INPUT_EMAIL => 'Email Input',
            self::INPUT_IMAGE => 'Image Upload',
            self::INPUT_NUMBER => 'Number Input',
            self::INPUT_TEXT => 'Text Input',
            self::INPUT_URL => 'URL Input',
            self::JSON => 'JSON Configuration',
            self::TEXTAREA => 'Multiline Text',
        };
    }

    /**
     * Define default field configuration for each setting type
     * Useful for initializing form inputs or validation.
     *
     * @return array<string, mixed>
     */
    public function defaultValue(): mixed
    {
        return match ($this) {
            self::INPUT_CHECKBOX => false,
            self::INPUT_EMAIL,
            self::INPUT_IMAGE,
            self::INPUT_NUMBER,
            self::INPUT_TEXT,
            self::INPUT_URL,
            self::TEXTAREA => '',
            self::JSON => [],
        };
    }

    /**
     * Returns metadata used for generating form fields dynamically.
     * Includes label, HTML input type, and optional constraints.
     *
     * @return array<string, mixed>
     */
    public function formField(): array
    {
        return match ($this) {
            self::INPUT_CHECKBOX => [
                'type' => 'checkbox',
                'label' => 'Enabled',
            ],
            self::INPUT_EMAIL => [
                'type' => 'email',
                'label' => 'Email',
                'placeholder' => 'you@example.com',
            ],
            self::INPUT_IMAGE => [
                'type' => 'file',
                'label' => 'Image',
                'accept' => 'image/*',
            ],
            self::INPUT_NUMBER => [
                'type' => 'number',
                'label' => 'Number',
                'min' => 0,
            ],
            self::INPUT_TEXT => [
                'type' => 'text',
                'label' => 'Text',
            ],
            self::INPUT_URL => [
                'type' => 'url',
                'label' => 'URL',
                'placeholder' => 'https://example.com',
            ],
            self::TEXTAREA => [
                'type' => 'textarea',
                'label' => 'Text Area',
                'rows' => 4,
            ],
            self::JSON => [
                'type' => 'json',
                'label' => 'JSON Editor',
            ],
        };
    }

    /**
     * Checks if this setting type is a standard HTML input element.
     *
     * @return bool
     */
    public function isInput(): bool
    {
        return str_starts_with($this->value, 'input:');
    }

    /**
     * Checks if this setting type is related to media.
     *
     * @return bool
     */
    public function isMedia(): bool
    {
        return $this === self::INPUT_IMAGE;
    }

    /**
     * Returns a list of all setting type values (for selection lists).
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

<?php

namespace Modules\Common\Traits\Adapters;

trait AppSettingAdapters
{
    /**
     * Get the setting name (not translated, as translations are not used).
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the setting value (not translated, as translations are not used).
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Get the setting type badge.
     *
     * @return string HTML representation of the type badge.
     */
    public function getTypeBadge(): string
    {
        $typeColors = [
            'input:text'    => 'primary',
            'input:textarea' => 'info',
            'input:number'  => 'success',
            'input:boolean' => 'warning',
            'input:file'    => 'dark',
        ];

        $type = $this->type ?? '';
        $mainType = explode(':', $type, 2)[1] ?? $type; // extract type after colon, fallback to $type

        $color = $typeColors[$type] ?? 'secondary';
        return sprintf('<div class="badge badge-%s">%s</div>', $color, ucfirst($mainType));
    }

    /**
     * Get formatted meta data.
     *
     * @return array
     */
    public function getFormattedMeta(): array
    {
        return json_decode($this->meta ?? '{}', true) ?: [];
    }

    /**
     * Get the setting key.
     *
     * @return string
     */
    public function getFormattedKey(): string
    {
        return "app_setting:{$this->key}";
    }
}

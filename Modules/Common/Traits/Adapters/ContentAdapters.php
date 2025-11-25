<?php

namespace Modules\Common\Traits\Adapters;

trait ContentAdapters
{
    use TimestampAdapters;

    /**
     * Get the display key for the content (for appends).
     *
     * @return string
     */
    public function getDisplayKeyAttribute(): string
    {
        return "content:{$this->key}";
    }

    /**
     * Get the badge HTML for the content key.
     *
     * @return string
     */
    public function getKeyBadgeAttribute(): string
    {
        return '<span class="badge soft-secondary">' . e($this->display_key) . '</span>';
    }

    /**
     * Get formatted meta data.
     *
     * @return ?array
     */
    public function getFormattedMetaAttribute(): ?array
    {
        if (is_array($this->meta)) {
            return $this->meta;
        }
        if (is_null($this->meta) || $this->meta === '') {
            return null;
        }
        $decoded = json_decode($this->meta, true);
        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Get the name attribute for the content (for appends).
     *
     * @return string|null
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Get the value attribute for the content (for appends).
     *
     * @return string|null
     */
    public function getValueAttribute(): ?string
    {
        return $this->attributes['value'] ?? null;
    }
}

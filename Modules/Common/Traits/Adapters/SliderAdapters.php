<?php

namespace Modules\Common\Traits\Adapters;

use Illuminate\Support\Facades\Storage;
use Modules\Common\Enums\SliderType;

trait SliderAdapters
{
    use TimestampAdapters;

    /**
     * --------------------------------------------------------------------------
     * Accessors
     * --------------------------------------------------------------------------
     * These are Eloquent accessor methods for convenient attribute access.
     * They allow you to retrieve formatted or computed values as if they were
     * regular model properties (e.g., $slider->status_badge).
     */

    /**
     * Accessor for the status badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status
            ? '<div class="badge soft-info">' . __('Active') . '</div>'
            : '<div class="badge soft-dark">' . __('Inactive') . '</div>';
    }

    /**
     * Accessor for the type badge HTML.
     *
     * @return string
     */
    public function getTypeBadgeAttribute(): string
    {
        $typeColors = [
            'basic' => 'primary',
            'hero' => 'info',
            'banner' => 'success',
            'custom' => 'warning',
        ];
        $color = $typeColors[$this->type] ?? 'secondary';
        return sprintf('<div class="badge badge-%s">%s</div>', $color, ucfirst($this->type));
    }

    /**
     * Accessor for the aspect ratio based on slider type enum.
     *
     * @return string|null
     */
    public function getAspectRatioAttribute(): ?string
    {
        return SliderType::tryFrom($this->type)?->aspectRatio();
    }

    /**
     * Accessor for the desktop image URL.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->desktop_media_path) {
            return null;
        }
        if (
            str_contains($this->desktop_media_path, '/assets/images') ||
            str_contains($this->desktop_media_path, 'https://')
        ) {
            return $this->desktop_media_path;
        }
        return asset('storage/' . $this->desktop_media_path);
    }

    /**
     * Accessor for the mobile image URL.
     *
     * @return string|null
     */
    public function getMobileImageUrlAttribute(): ?string
    {
        if (!$this->mobile_media_path) {
            return null;
        }
        if (
            str_contains($this->mobile_media_path, '/assets/images') ||
            str_contains($this->mobile_media_path, 'https://')
        ) {
            return $this->mobile_media_path;
        }
        return asset('storage/' . $this->mobile_media_path);
    }

    /**
     * Accessor for the thumbnail URL.
     *
     * @return ?string
     */
    public function getThumbnailAttribute(): ?string
    {
        if (!$this->desktop_media_path) {
            return null;
        }
        if (
            str_contains($this->desktop_media_path, '/assets/images') ||
            str_contains($this->desktop_media_path, 'https://')
        ) {
            return $this->desktop_media_path;
        }

        return $this->desktop_media_path
            ? Storage::url($this->desktop_media_path)
            : ('https://placehold.co/600x400?text=' . urlencode($this->heading ?? 'Slider'));
    }

    /**
     * Accessor for the slider's active state.
     *
     * @return bool
     */
    public function getIsActiveAttribute(): bool
    {
        return (bool) $this->status;
    }

    /**
     * Accessor for the slider's sort order.
     *
     * @return int
     */
    public function getSortOrderAttribute(): int
    {
        return (int) ($this->sort_order ?? 0);
    }

    /**
     * Accessor for the slider's heading (not translated).
     *
     * @return string|null
     */
    public function getHeadingAttribute(): ?string
    {
        return $this->attributes['heading'] ?? null;
    }

    /**
     * Accessor for the slider's sub-heading (not translated).
     *
     * @return string|null
     */
    public function getSubHeadingAttribute(): ?string
    {
        return $this->attributes['sub_heading'] ?? null;
    }

    /**
     * Accessor for the slider's description (not translated).
     *
     * @return string|null
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    /**
     * Accessor for the slider's alt text (not translated).
     *
     * @return string|null
     */
    public function getAltAttribute(): ?string
    {
        return $this->attributes['alt'] ?? null;
    }

    /**
     * Accessor for the slider's button text (from meta, not translated).
     *
     * @return string|null
     */
    public function getButtonTextAttribute(): ?string
    {
        $meta = $this->getMetaArray();
        return $meta['button_text'] ?? null;
    }

    /**
     * Accessor for the slider's button URL (from meta, not translated).
     *
     * @return string|null
     */
    public function getButtonUrlAttribute(): ?string
    {
        $meta = $this->getMetaArray();
        return $meta['button_url'] ?? null;
    }

    /**
     * Accessor for the slider's meta attribute as an array.
     *
     * @return array
     */
    public function getMetaArray(): array
    {
        // The column is 'meta'
        $meta = $this->attributes['meta'] ?? null;
        if (is_array($meta)) {
            return $meta;
        }
        if (is_string($meta)) {
            $decoded = json_decode($meta, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Use getMetaArray() for meta (Laravel appends expects getMetaAttribute)
     *
     * @return array
     */
    public function getMetaAttribute(): array
    {
        return $this->getMetaArray();
    }
}

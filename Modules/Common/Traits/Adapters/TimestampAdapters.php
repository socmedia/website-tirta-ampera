<?php

namespace Modules\Common\Traits\Adapters;

trait TimestampAdapters
{
    /**
     * Accessor for formatted created date (more human readable).
     *
     * @return string|null
     */
    public function getFormattedCreatedAtAttribute(): ?string
    {
        if (!$this->created_at) {
            return null;
        }
        // Example: 1 Januari 2024 pukul 14:30
        return carbon($this->created_at)->locale('id')->translatedFormat('j M Y. H:i');
    }

    /**
     * Accessor for formatted created date (readable, date only).
     *
     * @return string|null
     */
    public function getReadableCreatedAtAttribute(): ?string
    {
        if (!$this->created_at) {
            return null;
        }
        return carbon($this->created_at)->locale('id')->translatedFormat('j F Y');
    }

    /**
     * Accessor for formatted updated date (more human readable).
     *
     * @return string|null
     */
    public function getFormattedUpdatedAtAttribute(): ?string
    {
        if (!$this->updated_at) {
            return null;
        }
        // Example: 1 Januari 2024 pukul 14:30
        return carbon($this->updated_at)->locale('id')->translatedFormat('j M Y. H:i');
    }

    /**
     * Accessor for formatted updated date (readable, date only).
     *
     * @return string|null
     */
    public function getReadableUpdatedAtAttribute(): ?string
    {
        if (!$this->updated_at) {
            return null;
        }
        return carbon($this->updated_at)->locale('id')->translatedFormat('j F Y');
    }

    /**
     * Accessor for formatted published date (more human readable).
     *
     * @return string|null
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        if (!$this->published_at) {
            return null;
        }
        // Example: 1 Januari 2024 pukul 14:30
        return carbon($this->published_at)->locale('id')->translatedFormat('j M Y. H:i');
    }

    /**
     * Accessor for formatted published date (readable, date only).
     *
     * @return string|null
     */
    public function getReadablePublishedAtAttribute(): ?string
    {
        if (!$this->published_at) {
            return null;
        }
        return carbon($this->published_at)->locale('id')->translatedFormat('j F Y');
    }

    /**
     * Accessor for formatted deleted date (more human readable).
     *
     * @return string|null
     */
    public function getFormattedDeletedAtAttribute(): ?string
    {
        if (!$this->deleted_at) {
            return null;
        }
        // Example: 1 Januari 2024 pukul 14:30
        return carbon($this->deleted_at)->locale('id')->translatedFormat('j M Y. H:i');
    }

    /**
     * Accessor for formatted deleted date (readable, date only).
     *
     * @return string|null
     */
    public function getReadableDeletedAtAttribute(): ?string
    {
        if (!$this->deleted_at) {
            return null;
        }
        return carbon($this->deleted_at)->locale('id')->translatedFormat('j F Y');
    }
}

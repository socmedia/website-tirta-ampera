<?php

namespace Modules\Common\Traits\Adapters;

use Illuminate\Support\Facades\Storage;

trait PostAdapters
{
    use TimestampAdapters;

    /**
     * --------------------------------------------------------------------------
     * Accessors
     * --------------------------------------------------------------------------
     * These are Eloquent accessor methods for convenient attribute access.
     * They allow you to retrieve formatted or computed values as if they were
     * regular model properties (e.g., $post->status_badge).
     */

    /**
     * Accessor for the post's published badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute(): string
    {
        if (!empty($this->published_at)) {
            return '<div class="badge soft-info">' . __('Published') . '</div>';
        }
        return '<div class="badge soft-dark">' . __('Draft') . '</div>';
    }

    /**
     * Accessor for the post type badge HTML.
     *
     * @return string
     */
    public function getTypeBadgeAttribute(): string
    {
        $typeColors = [
            'article' => 'primary',
            'news' => 'info',
            'blog' => 'success',
            'custom' => 'warning',
        ];
        $color = $typeColors[$this->type] ?? 'secondary';
        return sprintf('<div class="badge badge-%s">%s</div>', $color, ucfirst($this->type));
    }

    /**
     * Accessor for the post's thumbnail URL.
     *
     * @return string
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (!$this->thumbnail) {
            $title = $this->title ?? 'Post';
            return 'https://placehold.co/600x400?text=' . urlencode($title);
        }
        if (
            str_contains($this->thumbnail, '/assets/images') ||
            str_contains($this->thumbnail, 'https://')
        ) {
            return $this->thumbnail;
        }

        return $this->thumbnail
            ? Storage::url($this->thumbnail)
            : ('https://placehold.co/600x400?text=' . urlencode($this->title ?? 'Post'));
    }

    /**
     * Accessor for the post's author name.
     *
     * @return ?string
     */
    public function getAuthorNameAttribute(): ?string
    {
        if (isset($this->attributes['author_name'])) {
            return $this->attributes['author_name'];
        }
        return null;
    }

    /**
     * Accessor for the post's category name.
     *
     * @return string|null
     */
    public function getCategoryNameAttribute(): ?string
    {
        if (isset($this->attributes['category_name'])) {
            return $this->attributes['category_name'];
        }
        return null;
    }

    /**
     * Accessor for the post's category slug.
     *
     * @return string|null
     */
    public function getCategorySlugAttribute(): ?string
    {
        if (isset($this->attributes['category_slug'])) {
            return $this->attributes['category_slug'];
        }
        return null;
    }

    /**
     * Accessor for the post's tags as array.
     *
     * @return array
     */
    public function getTagsArrayAttribute(): array
    {
        if (is_array($this->tags)) {
            return $this->tags;
        }
        if (is_string($this->tags)) {
            return array_filter(array_map('trim', explode(',', $this->tags)));
        }
        return [];
    }

    /**
     * Accessor for the post's reading time in minutes.
     *
     * @return int
     */
    public function getReadingTimeAttribute(): int
    {
        return (int) ($this->attributes['reading_time'] ?? 0);
    }

    /**
     * Accessor for the post's number of views.
     *
     * @return int
     */
    public function getNumberOfViewsAttribute(): int
    {
        return (int) ($this->attributes['number_of_views'] ?? 0);
    }

    /**
     * Accessor for the post's number of views, formatted using numberShortner helper.
     *
     * @return string
     */
    public function getFormattedNumberOfViewsAttribute(): string
    {
        $views = $this->number_of_views;
        return numberShortner($views);
    }

    /**
     * Accessor for the post's number of shares.
     *
     * @return int
     */
    public function getNumberOfSharesAttribute(): int
    {
        return (int) ($this->attributes['number_of_shares'] ?? 0);
    }

    /**
     * Accessor for the post's number of shares, formatted using numberShortner helper.
     *
     * @return string
     */
    public function getFormattedNumberOfSharesAttribute(): string
    {
        $shares = $this->number_of_shares;
        return numberShortner($shares);
    }

    /**
     * Accessor for the post's published state.
     *
     * @return bool
     */
    public function getIsPublishedAttribute(): bool
    {
        return !empty($this->published_at);
    }

    /**
     * Accessor for the post's title.
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        if (isset($this->attributes['title'])) {
            return $this->attributes['title'] ?? '';
        }
        return '';
    }

    /**
     * Accessor for the post's subject.
     *
     * @return string
     */
    public function getSubjectAttribute(): string
    {
        if (isset($this->attributes['subject'])) {
            return $this->attributes['subject'] ?? '';
        }
        return '';
    }

    // Excerpt accessor removed

    /**
     * Accessor for the post's meta title.
     *
     * @return string
     */
    public function getMetaTitleAttribute(): string
    {
        if (isset($this->attributes['meta_title'])) {
            return $this->attributes['meta_title'] ?? '';
        }
        return '';
    }

    /**
     * Accessor for the post's meta description.
     *
     * @return string
     */
    public function getMetaDescriptionAttribute(): string
    {
        if (isset($this->attributes['meta_description'])) {
            return $this->attributes['meta_description'] ?? '';
        }
        return '';
    }

    /**
     * Accessor for the post's readable published at date.
     *
     * @return string|null
     */
    public function getReadablePublishedAtAttribute(): ?string
    {
        if (!empty($this->published_at)) {
            try {
                return carbon($this->published_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return $this->published_at;
            }
        }
        return null;
    }

    /**
     * Accessor for the post's readable archived at date.
     *
     * @return string|null
     */
    public function getReadableArchivedAtAttribute(): ?string
    {
        if (!empty($this->archived_at)) {
            try {
                return carbon($this->archived_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return $this->archived_at;
            }
        }
        return null;
    }
}

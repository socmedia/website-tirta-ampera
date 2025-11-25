<?php

namespace Modules\Common\Traits\Adapters;

use Modules\Common\Traits\Adapters\TimestampAdapters;

trait CategoryAdapters
{
    use TimestampAdapters;

    /**
     * --------------------------------------------------------------------------
     * Accessors
     * --------------------------------------------------------------------------
     * These are Eloquent accessor methods for convenient attribute access.
     * They allow you to retrieve formatted or computed values as if they were
     * regular model properties (e.g., $category->status_badge).
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
     * Accessor for the featured badge HTML.
     *
     * @return string
     */
    public function getFeaturedBadgeAttribute(): string
    {
        return $this->featured
            ? '<div class="badge soft-info">' . __('Featured') . '</div>'
            : '<div class="badge soft-dark">' . __('Not Featured') . '</div>';
    }

    /**
     * Accessor for the group badge HTML.
     *
     * @return string
     */
    public function getGroupBadgeAttribute(): string
    {
        $groupColors = [
            'product' => 'success',
            'article' => 'info',
            'service' => 'warning',
            'page' => 'dark',
        ];

        $color = $groupColors[$this->group] ?? 'secondary';
        return sprintf('<div class="badge badge-%s">%s</div>', $color, ucfirst($this->group));
    }

    /**
     * Accessor for the full path of the category.
     * Now using only native columns: name, parent_id.
     *
     * @return string
     */
    public function getFullPathAttribute(): string
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', array_filter($path));
    }

    /**
     * Accessor for the image URL, using the 'image_path' column.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    /**
     * Accessor to determine if the category is root,
     * means parent_id is null for this structure.
     *
     * @return bool
     */
    public function getIsRootAttribute(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Accessor to determine if the category is a leaf (has no children).
     *
     * @return bool
     */
    public function getIsLeafAttribute(): bool
    {
        // children() relation must refer to categories table only, no translation table
        return !$this->children()->exists();
    }

    /**
     * Accessor for the level (depth) of the category.
     * Only uses parent_id, traversing up the tree.
     *
     * @return int
     */
    public function getLevelAttribute(): int
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }
}

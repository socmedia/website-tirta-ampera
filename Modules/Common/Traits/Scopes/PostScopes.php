<?php

namespace Modules\Common\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait PostScopes
{
    /**
     * Scope a query to only include published posts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at')
            ->whereNotNull('published_by')
            ->whereNull('archived_at');
    }

    /**
     * Scope a query to only include archived posts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeArchived(Builder $query)
    {
        return $query->whereNotNull('archived_at');
    }

    /**
     * Scope a query to only include draft posts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeDraft(Builder $query)
    {
        return $query->whereNull('published_at')
            ->whereNull('archived_at');
    }

    /**
     * Scope a query to filter posts by tag.
     *
     * @param  Builder  $query
     * @param  string|null  $keyword
     * @return Builder
     */
    public function scopeTag(Builder $query, ?string $keyword)
    {
        return $query->when($keyword, function (Builder $query) use ($keyword) {
            return $query->where('tags', 'like', '%' . $keyword . '%');
        });
    }

    /**
     * Scope a query to filter posts by type.
     *
     * @param  Builder  $query
     * @param  string|null  $keyword
     * @return Builder
     */
    public function scopeType(Builder $query, ?string $keyword)
    {
        return $query->when($keyword, function (Builder $query) use ($keyword) {
            return $query->where('type', $keyword);
        });
    }

    /**
     * Scope a query to filter posts by editor.
     *
     * @param  Builder  $query
     * @param  string|null  $keyword
     * @return Builder
     */
    public function scopeEditor(Builder $query, ?string $keyword)
    {
        // No editor column in posts table; implemented as before for completeness, can adjust based on relationships.
        return $query->when($keyword, function (Builder $query) use ($keyword) {
            return $query->whereHas('editor', function (Builder $q) use ($keyword) {
                $q->where('id', $keyword)
                    ->orWhere('email', $keyword);
            });
        });
    }

    /**
     * Scope a query to filter posts by author.
     *
     * @param  Builder  $query
     * @param  string|null  $keyword
     * @return Builder
     */
    public function scopeAuthor(Builder $query, ?string $keyword)
    {
        // posts table has 'author' and 'published_by' columns; let's filter on related user or author field
        return $query->when($keyword, function (Builder $query) use ($keyword) {
            return $query->where(function (Builder $q) use ($keyword) {
                $q->where('author', $keyword)
                    ->orWhereHas('writer', function (Builder $subQ) use ($keyword) {
                        $subQ->where('id', $keyword)
                            ->orWhere('email', $keyword);
                    });
            });
        });
    }

    /**
     * Scope a query to search posts by keyword.
     *
     * @param  Builder  $query
     * @param  string|null  $keyword
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $keyword)
    {
        return $query->when($keyword, function (Builder $query) use ($keyword) {
            $like = '%' . $keyword . '%';
            return $query->where(function (Builder $q) use ($like) {
                $q->where('title', 'like', $like)
                    ->orWhere('slug', 'like', $like)
                    ->orWhere('subject', 'like', $like)
                    ->orWhere('content', 'like', $like)
                    ->orWhere('tags', 'like', $like)
                    ->orWhere('meta_title', 'like', $like)
                    ->orWhere('meta_description', 'like', $like);
            });
        });
    }
}

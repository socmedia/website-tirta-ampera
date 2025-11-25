<?php

namespace Modules\Common\Traits\Scopes;

use \Illuminate\Database\Eloquent\Builder;

trait AppSettingScopes
{
    /**
     * Retrieve distinct groups from the app settings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByGroup($query)
    {
        return $query->select('group')->groupBy('group');
    }

    /**
     * Filter app settings by the specified group.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $group
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroup($query, $group)
    {
        return $query->when($group, function ($query) use ($group) {
            return $query->where('group', $group);
        });
    }

    /**
     * Search app settings based on various fields.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('group', 'like', '%' . $keyword . '%')
                    ->orWhere('key', 'like', '%' . $keyword . '%')
                    ->orWhere('type', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('value', 'like', '%' . $keyword . '%');
            });
        });
    }
}

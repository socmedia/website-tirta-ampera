<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes\Sortable;
use Modules\Common\Services\Filterables\CategoryFilters;
use Modules\Common\Traits\Adapters\CategoryAdapters;
use Modules\Common\Traits\Scopes\CategoryScopes;

class Category extends Model
{
    use Sortable;
    use CategoryScopes;
    use CategoryAdapters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'icon',
        'parent_id',
        'sort_order',
        'status',
        'featured',
        'group',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * Get the child categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}

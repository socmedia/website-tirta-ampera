<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Common\Traits\Adapters\SliderAdapters;
use Modules\Common\Traits\Scopes\SliderScopes;
use App\Traits\Scopes\Sortable;

class Slider extends Model
{
    use SliderAdapters;
    use SliderScopes;
    use Sortable;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'sliders';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sort_order' => 'integer',
        'status' => 'boolean',
        'meta' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'heading',
        'sub_heading',
        'description',
        'alt',
        'type',
        'desktop_media_path',
        'mobile_media_path',
        'sort_order',
        'status',
        'meta',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

<?php

namespace Modules\Common\Models;

use App\Traits\Scopes\Sortable;
use App\Traits\UniqueIdGenerator;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Traits\Scopes\FaqScopes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Common\Traits\Adapters\FaqAdapters;
use Modules\Common\Traits\Scopes\BelongsToCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
    use Sortable;
    use BelongsToCategory;
    use FaqScopes;
    use FaqAdapters;
    use UniqueIdGenerator;
    use SoftDeletes;

    /**
     * Create a new factory instance for the FAQ model.
     *
     * @return \Modules\Common\Database\factories\FaqFactory
     */
    protected static function newFactory()
    {
        // return \Modules\Common\Database\factories\FaqFactory::new();
    }

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the model's primary key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'sort_order' => 'integer',
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * The relationships that should always be loaded with the model.
     *
     * @var array
     */
    protected $with = [
        'category',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'slug',
        'answer',
        'category_id',
        'sort_order',
        'featured',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

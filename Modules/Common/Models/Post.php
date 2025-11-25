<?php

namespace Modules\Common\Models;

use Modules\Core\Models\User;
use App\Traits\Scopes\Sortable;
use App\Traits\UniqueIdGenerator;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Traits\Scopes\PostScopes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Common\Traits\Adapters\PostAdapters;
use Modules\Common\Traits\Scopes\BelongsToCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use BelongsToCategory;
    use Sortable;
    use PostAdapters;
    use PostScopes;
    use UniqueIdGenerator;
    use SoftDeletes;

    /**
     * Create a new factory instance for the Post model.
     *
     * @return \Modules\Common\Database\factories\PostFactory
     */
    protected static function newFactory()
    {
        return \Modules\Common\Database\Factories\PostFactory::new();
    }

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    public $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'subject',
        'content',
        'meta_title',
        'meta_description',
        'category_id',
        'type',
        'thumbnail',
        'tags',
        'reading_time',
        'number_of_views',
        'number_of_shares',
        'author',
        'published_by',
        'published_at',
        'archived_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the author of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writer()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    /**
     * Get the editor of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }
}

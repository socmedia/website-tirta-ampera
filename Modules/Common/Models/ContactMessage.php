<?php

namespace Modules\Common\Models;

use App\Traits\Scopes\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Traits\Adapters\ContactMessageAdapters;
use Modules\Common\Traits\Scopes\ContactMessageScopes;
use Modules\Core\Traits\Scopes\BelongsToUser;

class ContactMessage extends Model
{
    use HasFactory;
    use Sortable;
    use ContactMessageAdapters;
    use ContactMessageScopes;
    use BelongsToUser;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_messages';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'whatsapp_number' => 'integer',
        'seen_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'whatsapp_code',
        'whatsapp_number',
        'topic',
        'subject',
        'message',
        'seen_at',
        'seen_by',
    ];
}

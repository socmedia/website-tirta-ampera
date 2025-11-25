<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Traits\Adapters\AppSettingAdapters;
use Modules\Common\Traits\Scopes\AppSettingScopes;
use App\Traits\Scopes\Sortable;

class AppSetting extends Model
{
    use HasFactory;
    use Sortable;
    use AppSettingScopes;
    use AppSettingAdapters;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'type',
        'meta',
        'name',
        'value',
        'created_at',
        'updated_at',
    ];
}

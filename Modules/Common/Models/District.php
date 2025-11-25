<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes\Sortable;

class District extends Model
{
    use HasFactory;
    use Sortable;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'id_districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regency_id',
        'name',
    ];

    /**
     * Get the regency that owns the district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }
}

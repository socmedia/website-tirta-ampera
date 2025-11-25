<?php

namespace Modules\Core\Models;

use Modules\Common\Models\Regency;
use Modules\Common\Models\Village;
use Modules\Common\Models\District;
use Modules\Common\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Scopes\BelongsToVendor;
use Modules\Core\Traits\Adapters\VendorProfileAdapters;

class VendorProfile extends Model
{
    use HasFactory;
    use BelongsToVendor;
    use VendorProfileAdapters;

    /**
     * Define fillable column in the vendor profile table
     *
     * @var array
     */
    protected $fillable = [
        'vendor_id',
        'date_of_birth',
        'about',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'address',
        'postal_code',
        'gender',
        'phone_code',
        'phone_number',
        'whatsapp_code',
        'whatsapp_number',
        'social_medias',
        'allow_display_name',
        'created_at',
        'updated_at',
    ];

    /**
     * Define one to many province relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    /**
     * Define one to many regency relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    /**
     * Define one to many district relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Define one to many village relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}

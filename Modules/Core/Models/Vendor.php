<?php

namespace Modules\Core\Models;

use Illuminate\Support\Str;
use App\Traits\Scopes\Sortable;
use App\Traits\UniqueIdGenerator;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Core\Traits\Scopes\VendorScopes;
use Modules\Core\Notifications\VendorPasswordReset;
use Modules\Core\Traits\Adapters\VendorAdapters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Core\Notifications\VendorVerifyEmailNotification;

class Vendor extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Sortable;
    use VendorScopes;
    use VendorAdapters;
    use UniqueIdGenerator;

    protected $guard_name = 'vendor';

    /**
     * Get the factory instance for the Vendor model.
     *
     * @return \Modules\CoreDatabase\factories\VendorFactory
     */
    protected static function newFactory()
    {
        // return \Modules\CoreDatabase\factories\VendorFactory::new();
    }

    /**
     * Indicates if the model should be timestamped with auto-incrementing IDs.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the model's primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone_number',
        'avatar',
        'email_verified_at',
        'last_seen',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_code',
        'blocked_at',
        'blocked_by',
        'blocked_reason',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Send a password reset notification to the vendor.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendorPasswordReset($token));
    }

    /**
     * Send an email verification notification to the vendor.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VendorVerifyEmailNotification());
    }

    /**
     * Get the vendor's settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting()
    {
        // return $this->hasOne(VendorSetting::class);
    }
}

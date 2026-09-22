<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Book;
use App\Models\Categorypricing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'type',
        'company_name',
        'address',
        'postcode',
        'vatnumber',
        'companyregnumber',
        'vehicleregnumber',
        'make',
        'model',
        'cartype',
        'image',
        'hireandrewardinsurance',
        'goodsintransitinsuance',
        'publicliabilityinsurance',
        'drivinginsurance',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["user", "admin", "manager"][$value],
        );
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }

    /**
     * A driver who registered through the public form and is still waiting for
     * an administrator to verify their documents. They may log in before their
     * account is active - but only to reach the documentation area.
     */
    public function isPendingDriverApplicant(): bool
    {
        return (int) $this->getRawOriginal('type') === 2
            && (int) $this->status !== 1
            && $this->driverProfile?->application_status === DriverProfile::APPLICATION_PENDING;
    }

    public function driverDocuments()
    {
        return $this->hasMany(DriverDocument::class);
    }

    public function categoryPricings()
    {
        return $this->hasMany(Categorypricing::class);
    }
}

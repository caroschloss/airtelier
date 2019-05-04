<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'owner_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'owner_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'owner_id');
    }
}

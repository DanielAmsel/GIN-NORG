<?php

namespace App\Models;

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
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // 1-n relation to Role
    public function role(){
        return $this->hasMany(Role::class, 'id', 'id');
    }

    // 1-n relation to Sample
    public function sample(){
        return $this->hasMany(Sample::class, 'id', 'id');
    }


    // 1-n relation to ShippedSample
    public function shippedSample(){
        return $this->hasMany(ShippedSample::class);
    }

    // 1-n relation to RemovedSample
    public function removedSample(){
        return $this->hasMany(RemovedSample::class);
    }
}

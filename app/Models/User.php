<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\WishList;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [ 'unique_id', 'email', 'phone', 'password', 'location', 'firstname', 'lastname', 'status', 'auth_driver', 'avatar', 'isVerified'];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'isVerified' => false,
        'status' => true,
        'wishlists' => 0,
        'no_favourites' => 0
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function wishlists(){
        return $this->hasMany(Wishlist::class, 'user_id', 'unique_id');
    }

    public function favourites(){
        return $this->hasMany(Favourite::class, 'user_id', 'unique_id');
    }

    public function notification(){
        return $this->hasMany(Notification::class, 'receiver_id', 'unique_id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}

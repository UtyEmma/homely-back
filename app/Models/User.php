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

    protected $fillable = [ 'unique_id', 'email', 'password', 'location', 'firstname', 'lastname', 'status', 'auth_driver', 'avatar', 'isVerified'];

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

    public function favourties(){
        return $this->hasMany(Favourite::class, 'user_id', 'unique_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}

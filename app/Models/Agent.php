<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Agent extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [ 'unique_id', 'email', 'password', 'firstname', 'lastname', 'phone', 'avatar' ];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'no_of_listings' => 0,
        'isVerified' => false,
        'status' => true
    ];

    public function listings(){
       return $this->hasMany(Listing::class, 'agent_id', 'unique_id');
    }
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

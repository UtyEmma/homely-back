<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Agent;

class Wishlist extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['unique_id', 'user_id', 'category', 'no_bedrooms', 'no_bathrooms', 'desc', 'area', 'amenities', 'budget',
                            'state', 'city', 'additional', ];
                            
    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function user(){
        $this->belongsTo(User::class, 'unique_id', 'user_id');
    }

    public function matchByState(){
        $this->hasMany(Agent::class, 'state', 'state');
    }

    public function matchByCity(){
        $this->hasMany(Agent::class, 'city', 'city');
    }

}

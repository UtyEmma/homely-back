<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Wishlist extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['unique_id', 'user_id', 'category', 'no_rooms', 'features', 'amenities', 'budget',
                            'state', 'lga', 'area', 'landmark', 'additional', 'longitude', 'latitude'];
                            
    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function user(){
        $this->belongsTo(User::class, 'unique_id', 'user_id');
    }
}

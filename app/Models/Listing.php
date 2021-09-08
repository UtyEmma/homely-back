<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Agent;
use Laravel\Scout\Searchable;

class Listing extends Model
{
    use HasFactory, Searchable;

    public $asYouType = true;

    protected $guarded = [];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $attributes = [
        'status' => 'active',
        'views' => 0,
        'rented' => false,
        'reviews' => 0
    ];

    public function agent(){
        return $this->belongsTo(Agent::class, 'agent_id', 'unique_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'listing_id');
    }

    public function toSearchableArray(){
        $index = [
            'unique_id' => $this->unique_id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type
        ];
        return $index;
    }

}

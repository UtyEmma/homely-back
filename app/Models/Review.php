<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model{
    use HasFactory, SoftDeletes;

    protected $fillable = ['unique_id', 'listing_id', 'reviewer_id', 'agent_id', 'review', 'rating'];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $attributes = [
        'status' => 1,
        'reported' => false
    ];

    public function publisher(){
        return $this->belongsTo(User::class, 'reviewer_id', 'unique_id');
    }

    public function agent(){
        return $this->belongsTo(Agent::class, 'agent_id', 'unique_id');
    }

    public function listing(){
        return $this->belongsTo(Listing::class, 'listing_id', 'unique_id');
    }
}

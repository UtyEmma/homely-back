<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Listing extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $asYouType = true;

    public function agent(){
        return $this->belongsTo(Agent::class, 'agent_id', 'agent_id');
    }

     public function toSearchableArray()
     {
        $array = $this->toArray();
         return $array;
     }

}

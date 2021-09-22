<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'unique_id', 'agent_id', 'status', 'title', 'no_messages' ];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'status' => 'pending'
    ];

    public function chats (){
        return $this->hasMany(Chat::class, 'issue_id', 'unique_id');
    }

    public function agent (){
        return $this->belongsTo(Agent::class, 'agent_id', 'unique_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [ 'unique_id', 'sender', 'issue_id', 'message', 'status', 'agent_id' ];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'status' => 'unread',
    ];
}

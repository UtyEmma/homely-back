<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [ 'unique_id', 'user_id', 'user_type', 'title', 'message'];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;
}

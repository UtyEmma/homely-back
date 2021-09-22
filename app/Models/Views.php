<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Views extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'unique_id', 'type', 'type_id', 'user_id'];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'no_of_views' => 1
    ];
}

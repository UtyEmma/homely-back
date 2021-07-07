<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = ['unique_id', 'user_id', 'type', 'completed', 'role'];

    protected $primaryKey = 'unique_id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the phone associated with the user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public $attributes = [
        'completed' => false
    ];
}

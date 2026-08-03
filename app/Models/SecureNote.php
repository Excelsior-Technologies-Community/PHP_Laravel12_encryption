<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecureNote extends Model
{
    protected $fillable = ['title', 'content', 'password_hash', 'token', 'is_viewed', 'viewed_at'];

    protected $casts = [
        'is_viewed' => 'boolean',
        'viewed_at' => 'datetime',
    ];
}

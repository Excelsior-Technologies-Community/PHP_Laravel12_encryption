<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecureCredential extends Model
{
    protected $fillable = [
        'service_name',
        'username',
        'password',
        'api_key',
        'secret',
        'notes',
        'encryption_version',
    ];

    protected $casts = [
        'encryption_version' => 'integer',
    ];
}
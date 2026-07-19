<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'nik',
        'location',
        'username',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];
}

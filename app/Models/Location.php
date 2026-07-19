<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'section_id',
        'name',
        'is_active',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}

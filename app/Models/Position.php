<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'location_id',
        'name',
        'is_active',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}

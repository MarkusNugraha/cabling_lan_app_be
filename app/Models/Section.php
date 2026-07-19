<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Location;

class Section extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}

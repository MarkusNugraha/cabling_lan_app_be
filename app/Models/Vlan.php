<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vlan extends Model
{
    protected $fillable = [
        'vlan_id',
        'name',
        'note',
        'is_active',
    ];

    public function switchPorts()
    {
        return $this->hasMany(SwitchPort::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwitchPort extends Model
{
    protected $fillable = [
        'device_id',
        'port_number',
        'speed',
        'vlan_id',
        'note',
        'is_active',
    ];

    public function switch()
    {
        return $this->belongsTo(NetworkSwitch::class);
    }

    public function vlan()
    {
        return $this->belongsTo(Vlan::class);
    }
}

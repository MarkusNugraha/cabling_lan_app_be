<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkSwitch extends Model
{
    protected $table = 'switches';
    protected $fillable = [
        'device_id',
        'name',
        'total_ports',
        'brand',
        'model',
        'note',
        'is_active',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function switchPorts()
    {
        return $this->hasMany(SwitchPort::class);
    }
}

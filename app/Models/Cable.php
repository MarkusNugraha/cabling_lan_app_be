<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
    protected $fillable = [
        'cable_code',
        'from_switch_port_id',
        'to_device_id',
        'length_m',
        'note',
        'is_active',
    ];

    public function fromSwitchPort()
    {
        return $this->belongsTo(SwitchPort::class, 'from_switch_port_id');
    }

    public function toDevice()
    {
        return $this->belongsTo(Device::class, 'to_device_id');
    }
}

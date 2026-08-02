<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voip extends Model
{
    protected $fillable = [
        'device_id',
        'extension_number',
        'ip_address',
        'mac_address',
        'manufacturer',
        'model',
        'connected_pc_device_id',
        'note',
        'is_active',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function connectedPcDevice()
    {
        return $this->belongsTo(Device::class, 'connected_pc_device_id');
    }
}

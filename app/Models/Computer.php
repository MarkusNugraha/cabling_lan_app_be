<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $fillable = [
        'device_id',
        'hostname',
        'cpu',
        'ram_gb',
        'storage_gb',
        'storage_type',
        'operating_system',
        'ip_address',
        'mac_address',
        'manufacturer',
        'model',
        'note',
        'is_active',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

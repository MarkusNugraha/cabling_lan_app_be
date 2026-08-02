<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'id_asset',
        'pc_name',
        'serial_number',
        'device_category_id',
        'position_id',
        'note',
        'is_active'
    ];

    public function deviceCategory()
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function networkSwitch()
    {
        return $this->hasOne(NetworkSwitch::class);
    }

    public function voip()
    {
        return $this->hasOne(Voip::class);
    }

    public function computer()
    {
        return $this->hasOne(Computer::class);
    }
}

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
        'detail',
        'is_active',
    ];

    public function deviceCategory()
    {
        return $this->belongsTo(DeviceCategory::class);
    }
}

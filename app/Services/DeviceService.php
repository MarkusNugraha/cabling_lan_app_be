<?php

namespace App\Services;

use App\Models\Device;

class DeviceService
{
    public function create(array $data) : Device
    {
        return Device::create([
            'id_asset' => $data['id_asset'],
            'pc_name' => $data['pc_name'] ?? null,
            'serial_number' => $data['serial_number'],
            'device_category_id' => $data['device_category_id'],
            'position_id' => $data['position_id'],
            'note' => $data['note'] ?? null,
            'is_active' => true,
        ]);
    }
}

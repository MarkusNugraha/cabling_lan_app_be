<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function index()
    {
        $device = Device::all();
        return response()->json([
            'message' => 'Device retrieved successfully',
            'data' => $device,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_asset' => 'required|unique:devices',
                'pc_name' => 'nullable|unique:devices',
                'serial_number' => 'required|unique:devices',
                'device_category_id' => 'required|exists:device_categories,id',
                'position_id' => 'required|exists:positions,id',
                'note' => 'nullable'
            ],
            [
                'id_asset.required' => 'ID Asset is required.',
                'id_asset.unique' => 'This ID Asset is already registered.',

                'pc_name.unique' => 'This PC Name is already registered.',

                'serial_number.required' => 'Serial Number is required.',
                'serial_number.unique' => 'This Serial Number is already registered.',

                'device_category_id.required' => 'Device Category ID is required.',
                'device_category_id.exists' => 'Device Category not found.',

                'position_id.required' => 'Position ID is required.',
                'position_id.exists' => 'Position not found.'
            ]
        );

        $device = Device::create([
            'id_asset' => $validated['id_asset'],
            'pc_name' => $validated['pc_name'] ?? null,
            'serial_number' => $validated['serial_number'],
            'device_category_id' => $validated['device_category_id'],
            'position_id' => $validated['position_id'],
            'note' => $validated['note'] ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Device created successfully',
            'data' => $device,
        ], 201);
    }

    public function show(string $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Device retrieved successfully',
            'data' => $device,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'id_asset' => 'required|unique:devices,id_asset,' . $id,
                'pc_name' => 'nullable|unique:devices,pc_name,' . $id,
                'serial_number' => 'required|unique:devices,pc_name,' . $id,
                'device_category_id' => 'required|exists:device_categories,id',
                'position_id' => 'required|exists:positions,id',
                'note' => 'nullable',
                'is_active' => 'required|boolean'
            ],
            [
                'id_asset.required' => 'ID Asset is required.',
                'id_asset.unique' => 'This ID Asset is already registered.',

                'pc_name.unique' => 'This PC Name is already registered.',

                'serial_number.required' => 'Serial Number is required.',
                'serial_number.unique' => 'This Serial Number is already registered.',

                'device_category_id.required' => 'Device Category ID is required.',
                'device_category_id.exists' => 'Device Category not found.',

                'position_id.required' => 'Position ID is required.',
                'position_id.exists' => 'Position not found.',

                'is_active.required' => 'Device Status is required.',
                'is_active.boolean' => 'Device Status must be true or false.'
            ]
        );

        $device->update([
            'id_asset' => $validated['id_asset'],
            'pc_name' => $validated['pc_name'] ?? $device->pc_name,
            'serial_number' => $validated['serial_number'],
            'device_category_id' => $validated['device_category_id'],
            'position_id' => $validated['position_id'],
            'note' => $validated['note'] ?? $device->note,
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Device updated successfully',
            'data' => $device,
        ], 200);
    }
}

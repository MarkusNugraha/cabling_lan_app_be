<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetworkSwitch;
use App\Models\SwitchPort;
use App\Services\DeviceService;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SwitchController extends Controller
{
    public function __construct(private DeviceService $deviceService) {}

    public function index()
    {
        $switch = NetworkSwitch::all();
        return response()->json([
            'message' => 'Switch retrieved successfully',
            'data' => $switch,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                // Device Validation
                'id_asset' => 'required|unique:devices',
                'pc_name' => 'nullable|unique:devices',
                'serial_number' => 'required|unique:devices',
                'device_category_id' => 'required|exists:device_categories,id',
                'position_id' => 'required|exists:positions,id',

                // Switch Validation
                // 'device_id' => 'required|exists:devices,id|unique:switches,device_id',
                'name' => 'required|unique:switches',
                'total_ports' => 'required|integer',
                'brand' => 'required',
                'model' => 'required'
            ],
            [
                // Device Validation
                'id_asset.required' => 'ID Asset is required.',
                'id_asset.unique' => 'This ID Asset is already registered.',

                'pc_name.unique' => 'This PC Name is already registered.',

                'serial_number.required' => 'Serial Number is required.',
                'serial_number.unique' => 'This Serial Number is already registered.',

                'device_category_id.required' => 'Device Category ID is required.',
                'device_category_id.exists' => 'Device Category not found.',

                'position_id.required' => 'Position ID is required.',
                'position_id.exists' => 'Position not found.',

                // Switch Validation
                // 'device_id.required' => 'Device ID is required.',
                // 'device_id.exists' => 'Device not found.',
                // 'device_id.unique' => 'This Device ID is already registered.',

                'name.required' => 'Name is required.',
                'name.unique' => 'This Name is already registered.',

                'total_ports.required' => 'Total Ports is required.',
                'total_ports.integer' => 'Total Ports must be an integer.',

                'brand.required' => 'Brand is required.',

                'model.required' => 'Model is required.'
            ]
        );

        $device = $this->deviceService->create($validated);

        $switch = NetworkSwitch::create([
            // 'device_id' => $validated['device_id'],
            'device_id' => $device->id,
            'name' => $validated['name'],
            'total_ports' => $validated['total_ports'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'note' => $request->note,
            'is_active' => true
        ]);

        for ($portNumber = 1; $portNumber <= $validated['total_ports']; $portNumber++) {
            SwitchPort::create([
                'device_id' => $device->id,
                'port_number' => $portNumber,
                'is_active' => true,
            ]);
        }

        return response()->json([
            'message' => 'Switch created successfully',
            'data' => $switch,
        ], 201);
    }

    public function show(string $id)
    {
        $switch = NetworkSwitch::find($id);
        if (!$switch) {
            return response()->json([
                'message' => 'Switch not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Switch retrieved successfully',
            'data' => $switch,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $switch = NetworkSwitch::find($id);
        if (!$switch) {
            return response()->json([
                'message' => 'Switch not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'device_id' => 'required|exists:devices,id|unique:switches,device_id,' . $id,
                'name' => 'required|unique:switches,name,' . $id,
                'total_ports' => 'required|integer',
                'brand' => 'required',
                'model' => 'required',
                'is_active' => 'required|boolean'
            ],
            [
                'device_id.required' => 'Device ID is required.',
                'device_id.exists' => 'Device not found.',

                'name.required' => 'Name is required.',
                'name.unique' => 'This Name is already registered.',

                'total_ports.required' => 'Total Ports is required.',
                'total_ports.integer' => 'Total Ports must be an integer.',

                'brand.required' => 'Brand is required.',

                'model.required' => 'Model is required.',

                'is_active.required' => 'Switch Status is required.',
                'is_active.boolean' => 'Switch Status must be true or false.'
            ]
        );

        $switch->update([
            'device_id' => $validated['device_id'],
            'name' => $validated['name'],
            'total_ports' => $validated['total_ports'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'note' => $request->note,
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Switch updated successfully',
            'data' => $switch,
        ], 200);
    }
}

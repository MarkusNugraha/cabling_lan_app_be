<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Services\DeviceService;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ComputerController extends Controller
{
    public function __construct(private DeviceService $deviceService) {}
    public function index()
    {
        $computers = Computer::all();
        return response()->json([
            'message' => 'Computers retrieved successfully',
            'data' => $computers,
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

                // Computer Validation
                // 'device_id' => 'required|exists:devices,id',
                'hostname' => 'required|unique:computers',
                'cpu' => 'required',
                'ram_gb' => 'required|integer',
                'storage_gb' => 'required|integer',
                'storage_type' => 'required',
                'operating_system' => 'required',
                'ip_address' => 'required|unique:computers',
                'mac_address' => 'required|unique:computers',
                'manufacturer' => 'required',
                'model' => 'required',
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

                // Computer Validation
                // 'device_id.required' => 'Device ID is required.',
                // 'device_id.exists' => 'Device not found.',

                'hostname.required' => 'Hostname is required.',
                'hostname.unique' => 'Hostname already exists.',

                'cpu.required' => 'CPU is required.',

                'ram_gb.required' => 'RAM is required.',
                'ram_gb.integer' => 'RAM must be an integer.',

                'storage_gb.required' => 'Storage is required.',
                'storage_gb.integer' => 'Storage must be an integer.',

                'storage_type.required' => 'Storage Type is required.',

                'operating_system.required' => 'Operating System is required.',

                'ip_address.required' => 'IP Address is required.',
                'ip_address.unique' => 'IP Address already exists.',

                'mac_address.required' => 'MAC Address is required.',
                'mac_address.unique' => 'MAC Address already exists.',

                'manufacturer.required' => 'Manufacturer is required.',

                'model.required' => 'Model is required.',
            ]
        );

        $device = $this->deviceService->create($validated);

        $computer = Computer::create([
            'device_id' => $device->id,
            // 'device_id' => $validated['device_id'],
            'hostname' => $validated['hostname'],
            'cpu' => $validated['cpu'],
            'ram_gb' => $validated['ram_gb'],
            'storage_gb' => $validated['storage_gb'],
            'storage_type' => $validated['storage_type'],
            'operating_system' => $validated['operating_system'],
            'ip_address' => $validated['ip_address'],
            'mac_address' => $validated['mac_address'],
            'manufacturer' => $validated['manufacturer'],
            'model' => $validated['model'],
            'note' => $request->note ?? null,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Computer created successfully',
            'data' => $computer,
        ], 201);
    }

    public function show(string $id)
    {
        $computer = Computer::find($id);
        if (!$computer) {
            return response()->json([
                'message' => 'Computer not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Computer retrieved successfully',
            'data' => $computer,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $computer = Computer::find($id);
        if (!$computer) {
            return response()->json([
                'message' => 'Computer not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'device_id' => 'required|exists:devices,id',
                'hostname' => 'required|unique:computers,hostname,' . $id,
                'cpu' => 'required',
                'ram_gb' => 'required',
                'storage_type' => 'required',
                'operating_system' => 'required',
                'ip_address' => 'required|unique:computers,ip_address,' . $id,
                'mac_address' => 'required|unique:computers,mac_address,' . $id,
                'manufacturer' => 'required',
                'model' => 'required',
                'is_active' => 'required|boolean',
            ],
            [
                'device_id.required' => 'Device ID is required.',
                'device_id.exists' => 'Device not found.',

                'hostname.required' => 'Hostname is required.',
                'hostname.unique' => 'Hostname already exists.',

                'cpu.required' => 'CPU is required.',

                'ram_gb.required' => 'RAM is required.',

                'storage_type.required' => 'Storage Type is required.',

                'operating_system.required' => 'Operating System is required.',

                'ip_address.required' => 'IP Address is required.',
                'ip_address.unique' => 'IP Address already exists.',

                'mac_address.required' => 'MAC Address is required.',
                'mac_address.unique' => 'MAC Address already exists.',

                'manufacturer.required' => 'Manufacturer is required.',

                'model.required' => 'Model is required.',

                'is_active.required' => 'Computer Status is required.',
                'is_active.boolean' => 'Computer Status must be true or false.'
            ]
        );

        $computer->update([
            'device_id' => $validated['device_id'],
            'hostname' => $validated['hostname'],
            'cpu' => $validated['cpu'],
            'ram_gb' => $validated['ram_gb'],
            'storage_type' => $validated['storage_type'],
            'operating_system' => $validated['operating_system'],
            'ip_address' => $validated['ip_address'],
            'mac_address' => $validated['mac_address'],
            'manufacturer' => $validated['manufacturer'],
            'model' => $validated['model'],
            'note' => $request->note ?? $computer->note,
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'message' => 'Computer updated successfully',
            'data' => $computer,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voip;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoipController extends Controller
{
    public function index()
    {
        $voip = Voip::all();
        return response()->json([
            'message' => 'Voip retrieved successfully',
            'data' => $voip,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'device_id' => 'required|exists:devices,id',
                'extension_number' => 'required|unique:voips',
                'ip_address' => 'required|unique:voips',
                'mac_address' => 'required|unique:voips',
                'manufacturer' => 'required',
                'model' => 'required',
                'connected_pc_device_id' => 'nullable|exists:devices,id',
            ],
            [
                'device_id.required' => 'Device ID is required.',
                'device_id.exists' => 'Device not found.',

                'extension_number.required' => 'Extension Number is required.',
                'extension_number.unique' => 'Extension Number already exists.',

                'ip_address.required' => 'IP Address is required.',
                'ip_address.unique' => 'IP Address already exists.',

                'mac_address.required' => 'MAC Address is required.',
                'mac_address.unique' => 'MAC Address already exists.',

                'manufacturer.required' => 'Manufacturer is required.',

                'model.required' => 'Model is required.',

                'connected_pc_device_id.exists' => 'Connected PC Device not found.',
            ]
        );

        $voip = Voip::create([
            'device_id' => $validated['device_id'],
            'extension_number' => $validated['extension_number'],
            'ip_address' => $validated['ip_address'],
            'mac_address' => $validated['mac_address'],
            'manufacturer' => $validated['manufacturer'],
            'model' => $validated['model'],
            'connected_pc_device_id' => $validated['connected_pc_device_id'] ?? null,
            'note' => $request->note ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Voip created successfully',
            'data' => $voip,
        ], 201);
    }

    public function show(string $id)
    {
        $voip = Voip::find($id);
        if (!$voip) {
            return response()->json([
                'message' => 'Voip not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Voip retrieved successfully',
            'data' => $voip,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $voip = Voip::find($id);
        if (!$voip) {
            return response()->json([
                'message' => 'Voip not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'device_id' => 'required|exists:devices,id',
                'extension_number' => 'required|unique:voips,extension_number,' . $id,
                'ip_address' => 'required|unique:voips,ip_address,' . $id,
                'mac_address' => 'required|unique:voips,mac_address,' . $id,
                'manufacturer' => 'required',
                'model' => 'required',
                'connected_pc_device_id' => 'nullable|exists:devices,id',
                'is_active' => 'required|boolean'
            ],
            [
                'device_id.required' => 'Device ID is required.',
                'device_id.exists' => 'Device not found.',

                'extension_number.required' => 'Extension Number is required.',
                'extension_number.unique' => 'Extension Number already exists.',

                'ip_address.required' => 'IP Address is required.',
                'ip_address.unique' => 'IP Address already exists.',

                'mac_address.required' => 'MAC Address is required.',
                'mac_address.unique' => 'MAC Address already exists.',

                'manufacturer.required' => 'Manufacturer is required.',

                'model.required' => 'Model is required.',

                'connected_pc_device_id.exists' => 'Connected PC Device not found.',

                'is_active.required' => 'Voip status is required.',
                'is_active.boolean' => 'Voip status must be a boolean.',
            ]
        );

        $voip->update([
            'device_id' => $validated['device_id'],
            'extension_number' => $validated['extension_number'],
            'ip_address' => $validated['ip_address'],
            'mac_address' => $validated['mac_address'],
            'manufacturer' => $validated['manufacturer'],
            'model' => $validated['model'],
            'connected_pc_device_id' => $validated['connected_pc_device_id'] ?? $voip->connected_pc_device_id,
            'note' => $validated['note'] ?? $voip->note,
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Voip updated successfully',
            'data' => $voip,
        ], 200);
    }
}

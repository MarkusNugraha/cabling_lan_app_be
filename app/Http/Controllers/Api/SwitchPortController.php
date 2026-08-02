<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SwitchPort;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SwitchPortController extends Controller
{
    public function index()
    {
        $switch_port = SwitchPort::all();
        return response()->json([
            'message' => 'Switch Port retrieved successfully',
            'data' => $switch_port,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'device_id' => 'required|exists:devices,id',
                'port_number' => [
                    'required',
                    'integer',
                    Rule::unique('switch_ports')
                        ->where(function ($query) use ($request) {
                            return $query->where('device_id', $request->device_id);
                        }),
                ],
                'vlan_id' => 'nullable|exists:vlans,id'
            ],
            [
                'device_id.required' => 'Device ID is required.',
                'device_id.exists' => 'Device not found.',

                'port_number.required' => 'Port Number is required.',
                'port_number.integer' => 'Port Number must be an integer.',
                'port_number.unique' => 'Port Number already exists for this switch.',

                'vlan_id.exists' => 'VLAN not found.'
            ]
        );

        $switch_port = SwitchPort::create([
            'device_id' => $validated['device_id'],
            'port_number' => $validated['port_number'],
            'speed' => $request->speed ?? null,
            'vlan_id' => $validated['vlan_id'] ?? null,
            'note' => $request->note ?? null,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Switch Port created successfully',
            'data' => $switch_port,
        ], 201);
    }

    public function show(string $id)
    {
        $switch_port = SwitchPort::find($id);
        if (!$switch_port) {
            return response()->json([
                'message' => 'Switch Port not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Switch Port retrieved successfully',
            'data' => $switch_port,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $switch_port = SwitchPort::find($id);
        if (!$switch_port) {
            return response()->json([
                'message' => 'Switch Port not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'vlan_id' => 'nullable|exists:vlans,id',
                'is_active' => 'required|boolean'
            ],
            [
                'vlan_id.exists' => 'VLAN not found.',

                'is_active.required' => 'Switch Port Status is required.',
                'is_active.boolean' => 'Switch Port Status must be true or false.'
            ]
        );

        $switch_port->update([
            'speed' => $request->speed ?? $switch_port->speed,
            'vlan_id' => $validated['vlan_id'] ?? $switch_port->vlan_id,
            'note' => $request->note ?? $switch_port->note,
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Switch Port updated successfully',
            'data' => $switch_port,
        ], 200);
    }
}

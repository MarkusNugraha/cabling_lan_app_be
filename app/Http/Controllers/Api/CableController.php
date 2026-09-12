<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cable;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CableController extends Controller
{
    public function index()
    {
        $cable = Cable::all();
        return response()->json([
            'message' => 'Cables retrieved successfully',
            'data' => $cable,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'cable_code' => 'required|unique:cables,cable_code',
                'from_switch_port_id' => 'nullable|exists:switch_ports,id',
                'to_device_id' => 'nullable|exists:devices,id',
            ],
            [
                'cable_code.required' => 'Cable Code is required.',
                'cable_code.unique' => 'Cable Code already exists.',

                'from_switch_port_id.exists' => 'From Switch Port not found.',
                'to_device_id.exists' => 'To Device not found.',
            ]
        );

        $cable = Cable::create([
            'cable_code' => $validated['cable_code'],
            'from_switch_port_id' => $validated['from_switch_port_id'] ?? null,
            'to_device_id' => $validated['to_device_id'] ?? null,
            'length_m' => $request->length_m ?? null,
            'note' => $request->note ?? null,
            'is_active' => true
        ]);
        return response()->json([
            'message' => 'Cable created successfully',
            'data' => $cable,
        ], 201);
    }

    public function show(string $id)
    {
        $cable = Cable::find($id);
        if (!$cable) {
            return response()->json([
                'message' => 'Cable not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Cable retrieved successfully',
            'data' => $cable,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $cable = Cable::find($id);
        if (!$cable) {
            return response()->json([
                'message' => 'Cable not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'cable_code' => 'required|unique:cables,cable_code, ' . $id,
                'from_switch_port_id' => 'nullable|exists:switch_ports,id',
                'to_device_id' => 'nullable|exists:devices,id',
                'is_active' => 'required|boolean'
            ],
            [
                'cable_code.required' => 'Cable Code is required.',
                'cable_code.unique' => 'Cable Code already exists.',

                'from_switch_port_id.exists' => 'From Switch Port not found.',
                'to_device_id.exists' => 'To Device not found.',

                'is_active.required' => 'Cable Status is required.',
                'is_active.boolean' => 'Cable Status must be a boolean.',
            ]
        );

        $cable->update([
            'cable_code' => $validated['cable_code'],
            'from_switch_port_id' => $validated['from_switch_port_id'] ?? $cable->from_switch_port_id,
            'to_device_id' => $validated['to_device_id'] ?? $cable->to_device_id,
            'length_m' => $request->length_m ?? $cable->length_m,
            'note' => $request->note ?? $cable->note,
            'is_active' => $validated['is_active']
        ]);
        return response()->json([
            'message' => 'Cable updated successfully',
            'data' => $cable,
        ], 200);
    }
}

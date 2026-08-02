<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vlan;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VlanController extends Controller
{
    public function index()
    {
        $vlan = Vlan::all();
        return response()->json([
            'message' => 'Vlan retrieved successfully',
            'data' => $vlan,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'vlan_id' => 'required|unique:vlans',
                'name' => 'required|unique:vlans'
            ],
            [
                'vlan_id.required' => 'Vlan ID is required.',
                'vlan_id.unique' => 'This Vlan ID is already registered.',

                'name.required' => 'Name is required.',
                'name.unique' => 'This name is already registered.'
            ]
        );

        $vlan = Vlan::create([
            'vlan_id' => $validated['vlan_id'],
            'name' => $validated['name'],
            'note' => $request->note,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Vlan created successfully',
            'data' => $vlan,
        ], 201);
    }

    public function show(String $id)
    {
        $vlan = Vlan::find($id);
        if (!$vlan) {
            return response()->json([
                'message' => 'Vlan not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Vlan retrieved successfully',
            'data' => $vlan,
        ], 200);
    }

    public function update(Request $request, String $id)
    {
        $vlan = Vlan::find($id);
        if (!$vlan) {
            return response()->json([
                'message' => 'Vlan not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'vlan_id' => 'required|unique:vlans,vlan_id,' . $id,
                'name' => 'required|unique:vlans,name,' . $id,
                'is_active' => 'required|boolean'
            ],
            [
                'vlan_id.required' => 'Vlan ID is required.',
                'vlan_id.unique' => 'This Vlan ID is already registered.',

                'name.required' => 'Name is required.',
                'name.unique' => 'This name is already registered.',

                'is_active.required' => 'Vlan Status is required.',
                'is_active.boolean' => 'Vlan Status must be true or false.',
            ]
        );

        $vlan->update([
            'vlan_id' => $validated['vlan_id'],
            'name' => $validated['name'],
            'note' => $request->note,
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Vlan updated successfully',
            'data' => $vlan,
        ], 200);
    }
}

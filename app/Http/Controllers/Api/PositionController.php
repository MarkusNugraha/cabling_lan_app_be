<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::all();
        return response()->json([
            'message' => 'Position retrieved successfully',
            'data' => $position,
        ], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'location_id' => 'required | exists:locations,id',
                'name' => [
                    'required',
                    Rule::unique('positions')->where(function ($query) use ($request) {
                        return $query->where('location_id', $request->location_id);
                    }),
                ],

            ],
            [
                'location_id.required' => 'Location is required.',
                'location_id.exists' => 'Location not found.',

                'name.required' => 'Position name is required.',
                'name.unique' => 'This location is already registered.',
            ]
        );

        $position = Position::create([
            'location_id' => $validated['location_id'],
            'name' => $validated['name'],
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Position created successfully',
            'data' => $position,
        ], 201);
    }

    public function show(string $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Position retrieved successfully',
            'data' => $position,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'location_id' => 'required | exists:locations,id',
                'name' => [
                    'required',
                    Rule::unique('positions')
                        ->where(function ($query) use ($request) {
                            return $query->where('location_id', $request->location_id);
                        })
                        ->ignore($id),
                ],
                'is_active' => 'required | boolean'
            ],
            [
                'location_id.required' => 'Location is required.',
                'location_id.exists' => 'Location not found.',

                'name.required' => 'Position name is required.',
                'name.unique' => 'This location is already registered.',

                'is_active.required' => 'Position status is required.'
            ]
        );

        $position->update([
            'location_id' => $validated['location_id'],
            'name' => $validated['name'],
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Position updated successfully',
            'data' => $position,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::all();
        return response()->json([
            'message' => 'Location retrieved successfully',
            'data' => $location,
        ], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'section_id' => 'required | exists:sections,id',
                'name' => [
                    'required',
                    Rule::unique('locations')->where(function ($query) use ($request) {
                        return $query->where('section_id', $request->section_id);
                    }),
                ],

            ],
            [
                'section_id.required' => 'Section is required.',
                'section_id.exists' => 'Section not found.',

                'name.required' => 'Location name is required.',
                'name.unique' => 'This location is already registered.',
            ]
        );

        $location = Location::create([
            'section_id' => $validated['section_id'],
            'name' => $validated['name'],
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Location created successfully',
            'data' => $location,
        ], 201);
    }

    public function show(string $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json([
                'message' => 'Location not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Location retrieved successfully',
            'data' => $location,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json([
                'message' => 'Location not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'section_id' => 'required | exists:sections,id',
                'name' => [
                    'required',
                    Rule::unique('locations')
                        ->where(function ($query) use ($request) {
                            return $query->where('section_id', $request->section_id);
                        })
                        ->ignore($id),
                ],
                'is_active' => 'required | boolean'
            ],
            [
                'section_id.required' => 'Section is required.',
                'section_id.exists' => 'Section not found.',

                'name.required' => 'Location name is required.',
                'name.unique' => 'This location is already registered.',

                'is_active.required' => 'Location status is required.'
            ]
        );

        $location->update([
            'section_id' => $validated['section_id'],
            'name' => $validated['name'],
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Location updated successfully',
            'data' => $location,
        ], 200);
    }
}

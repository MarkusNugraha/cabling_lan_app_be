<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Section;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $section = Section::all();
        return response()->json([
            'message' => 'Section retrieved successfully',
            'data' => $section,
        ], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required | unique:sections,name',
            ],
            [
                'name.required' => 'Section name is required.',
            ]
        );

        $section = Section::create([
            'name' => $validated['name'],
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Section created successfully',
            'data' => $section,
        ], 201);
    }

    public function show(string $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json([
                'message' => 'Section not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Section retrieved successfully',
            'data' => $section,
        ], 200);
    }

    public function update(Request $request, string $id)
    {

        $section = Section::find($id);

        if (!$section) {
            return response()->json([
                'message' => 'Section not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'name' => 'required | unique:sections,name,' . $id,
                'is_active' => 'required | boolean'
            ],
            [
                'name.required' => 'Section name is required.',
                'is_active.required' => 'Section status is required.'
            ]
        );

        $section->update([
            'name' => $validated['name'],
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Section updated successfully',
            'data' => $section,
        ], 200);
    }
}

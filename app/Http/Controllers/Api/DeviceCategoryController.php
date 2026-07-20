<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceCategory;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceCategoryController extends Controller
{
    public function index()
    {
        $deviceCategory = DeviceCategory::all();
        return response()->json([
            'message' => 'Device Category retrieved successfully',
            'data' => $deviceCategory,
        ], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required | unique:device_categories,name',
            ],
            [
                'name.required' => 'Device Category name is required.',
                'name.unique' => 'This device category is already registered.',
            ]
        );

        $deviceCategory = DeviceCategory::create([
            'name' => $validated['name'],
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Device Category created successfully',
            'data' => $deviceCategory,
        ], 201);
    }

    public function show(string $id)
    {
        $deviceCategory = DeviceCategory::find($id);
        if (!$deviceCategory) {
            return response()->json([
                'message' => 'Device Category not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Device Category retrieved successfully',
            'data' => $deviceCategory,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $deviceCategory = DeviceCategory::find($id);
        if (!$deviceCategory) {
            return response()->json([
                'message' => 'Device Category not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'name' => 'required | unique:device_categories,name,' . $id,
                'is_active' => 'required | boolean'
            ],
            [
                'name.required' => 'Device Category name is required.',
                'name.unique' => 'This device category is already registered.',

                'is_active.required' => 'Status is required.',
                'is_active.boolean' => 'Status must be true or false.',
            ]
        );

        $deviceCategory->update([
            'name' => $validated['name'],
            'is_active' => $validated['is_active']
        ]);

        return response()->json([
            'message' => 'Device Category updated successfully',
            'data' => $deviceCategory,
        ], 200);
    }


}

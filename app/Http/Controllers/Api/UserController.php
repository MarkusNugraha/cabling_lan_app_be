<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nik' => 'required | unique:users,nik',
                'location' => 'required',
                'username' => 'required',
                'email' => 'required | email | unique:users,email',
                'password' => 'required | min:6',
            ],
            [
                'nik.required' => 'NIK is required.',
                'nik.unique' => 'This NIK is already registered.',

                'location.required' => 'Location is required.',

                'username.required' => 'Username is required.',

                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
            ]
        );

        $user = User::create([
            'nik' => $validated['nik'],
            'location' => $validated['location'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $validated = $request->validate(
            [
                'nik' => 'required | unique:users,nik,' . $id,
                'location' => 'required',
                'username' => 'required',
                'email' => 'required | email | unique:users,email,' . $id,
                'password' => 'nullable | min:6',
            ],
            [
                'nik.required' => 'NIK is required.',
                'nik.unique' => 'This NIK is already registered.',

                'location.required' => 'Location is required.',

                'username.required' => 'Username is required.',

                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
            ]
        );

        $user->nik = $validated['nik'];
        $user->location = $validated['location'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}

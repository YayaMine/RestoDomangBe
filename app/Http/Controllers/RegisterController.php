<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        // Log request input for debugging
        Log::info('Register request received', $request->all());

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Automatically set role to member
        ]);

        // Log user creation
        Log::info('User successfully registered', ['user' => $user]);

        // Return a success response
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }

    public function createUser(Request $request)
{
    // Log request input for debugging
    Log::info('Create User request received', $request->all());

    // Validate input data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role' => 'nullable|in:admin,member', // Role validation
    ]);

    try {
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'member', // Default role to 'member'
        ]);

        // Log user creation
        Log::info('User successfully created', ['user' => $user]);

        // Return a success response
        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user,
        ], 201);
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error creating user', ['error' => $e->getMessage()]);

        // Return an error response
        return response()->json([
            'message' => 'Failed to create user.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
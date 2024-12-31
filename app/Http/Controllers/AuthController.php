<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Buat token login menggunakan Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Sertakan role dalam respons
            ],
            'token' => $token,
        ]);
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request)
    {
        // Hapus semua token untuk user saat ini
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * Get the authenticated user.
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, // Sertakan role dalam respons
        ]);
    }
}

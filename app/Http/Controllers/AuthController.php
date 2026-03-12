<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $role = $request->input('role', 'pegawai');

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($role === 'mitra') {
            $user = User::where('phone', $request->username)
                ->where('role', 'mitra')
                ->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'phone' => ['Nomor telepon atau password salah.'],
                ]);
            }
        } else {
            $user = User::where('username', $request->username)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'username' => ['Username atau password salah.'],
                ]);
            }
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout.',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('username', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $sortBy = $request->input('sort_by', 'role');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = (int) $request->input('per_page', 20);

        if ($sortBy === 'role') {
            $query->orderByRaw("CASE WHEN role='admin' THEN 0 WHEN role='pegawai' THEN 1 ELSE 2 END " . ($sortDir === 'desc' ? 'DESC' : 'ASC'));
            $query->orderBy('name', 'asc');
        } else {
            $query->orderBy($sortBy, $sortDir);
            if ($sortBy === 'name') {
                $query->orderByRaw("CASE WHEN role='admin' THEN 0 WHEN role='pegawai' THEN 1 ELSE 2 END ASC");
            }
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $role = $request->input('role', 'pegawai');

        $rules = [
            'name'     => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:pegawai,mitra,admin',
        ];

        if ($role === 'mitra') {
            $rules['phone'] = 'required|string|unique:users,phone';
        } else {
            $rules['username'] = 'required|string|unique:users,username';
        }

        $validated = $request->validate($rules);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User berhasil dibuat.',
            'data'    => $user,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $effectiveRole = $request->input('role', $user->role);

        $rules = [
            'name'     => 'sometimes|string|max:255',
            'password' => 'sometimes|nullable|string|min:6',
            'role'     => 'sometimes|in:pegawai,mitra,admin',
        ];

        if ($effectiveRole === 'mitra') {
            $rules['phone'] = ['sometimes', 'string', Rule::unique('users', 'phone')->ignore($id)];
        } else {
            $rules['username'] = ['sometimes', 'string', Rule::unique('users', 'username')->ignore($id)];
        }

        $validated = $request->validate($rules);

        // Remove empty password
        if (isset($validated['password']) && $validated['password'] === '') {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User berhasil diperbarui.',
            'data'    => $user->fresh(),
        ]);
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin tidak dapat dihapus.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}

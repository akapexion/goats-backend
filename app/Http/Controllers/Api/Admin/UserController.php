<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,farmer,customer',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status']   = 'active';

        $user = User::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'User created',
            'data'    => $user,
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => true,
            'data'   => $user->load('farmerProfile'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'    => 'sometimes|string|max:100',
            'email'   => 'sometimes|email|max:100|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role'    => 'sometimes|in:admin,farmer,customer',
        ]);

        $user->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'User updated',
            'data'    => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'User deleted',
        ]);
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User status updated',
            'data'    => $user,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Menampilkan semua roles
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }

    // Menyimpan role baru
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,role|max:50',
        ]);

        $role = Role::create([
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dibuat',
            'data' => $role,
        ]);
    }

    // Menampilkan role berdasarkan ID
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $role,
        ]);
    }

    // Mengupdate role
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|unique:roles,role,' . $id . '|max:50',
        ]);

        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan',
            ], 404);
        }

        $role->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil diupdate',
            'data' => $role,
        ]);
    }

    // Menghapus role
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan',
            ], 404);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus',
        ]);
    }
}

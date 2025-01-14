<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Menampilkan semua admin
    public function index()
    {
        $admins = Admin::with('role')->get();

        return response()->json([
            'success' => true,
            'data' => $admins,
        ]);
    }

    // Menyimpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'username' => 'required|unique:admins,username|max:50',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil ditambahkan',
            'data' => $admin,
        ]);
    }

    // Menampilkan admin berdasarkan ID
    public function show($id)
    {
        $admin = Admin::with('role')->find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $admin,
        ]);
    }

    // Mengupdate data admin
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'name'     => 'required|max:50',
            'username' => 'required|unique:admins,username,' . $id . '|max:50',
            'password' => 'nullable|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $admin->username = $request->username;
        $admin->role_id = $request->role_id;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil diupdate',
            'data' => $admin,
        ]);
    }

    // Menghapus admin
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan',
            ], 404);
        }

        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus',
        ]);
    }
}

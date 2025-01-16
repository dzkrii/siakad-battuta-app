<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // index
    public function index()
    {
        // search by name / username, pagination 10
        $admins = Admin::where('name', 'like', '%' . request('search') . '%')
            ->orWhere('username', 'like', '%' . request('search') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.admin.index', [
            'admins' => $admins,
            'type_menu' => 'data-master',
        ]);
    }

    // create
    public function create()
    {
        return view('pages.admin.create', [
            'type_menu' => 'data-master',
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'username' => 'required|unique:admins,username|max:50',
            'password' => 'required|min:4',
        ]);

        Admin::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'  => 1,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin berhasil ditambahkan');
    }

    // edit
    public function edit(Admin $admin)
    {
        return view('pages.admin.edit', [
            'admin'     => $admin,
            'type_menu' => 'data-master',
        ]);
    }

    // update
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'username' => 'required|unique:admins,username,' . $admin->id . '|max:50',
            'password' => 'nullable|min:4',
        ]);

        $admin->update([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin berhasil diperbarui');
    }

    // destroy
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'Admin berhasil dihapus');
    }
}

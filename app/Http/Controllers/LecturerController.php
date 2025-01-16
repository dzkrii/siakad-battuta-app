<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    // index
    public function index()
    {
        // search by nidn, name, telepon, alamat, pagination 10
        $lecturers = Lecturer::where('nidn', 'like', '%' . request('search') . '%')
            ->orWhere('name', 'like', '%' . request('search') . '%')
            ->orWhere('telepon', 'like', '%' . request('search') . '%')
            ->orWhere('alamat', 'like', '%' . request('search') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.lecturer.index', [
            'lecturers' => $lecturers,
            'type_menu' => 'data-master',
        ]);
    }

    // create
    public function create()
    {
        return view('pages.lecturer.create', [
            'type_menu' => 'data-master',
        ]);
    }

    // store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|unique:lecturers,nidn',
            'name' => 'required|string|max:255',
            'password' => 'required|min:4',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/lecturers');
            $validated['foto'] = Storage::url($path);
        }

        Lecturer::create([
            'nidn' => $request['nidn'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'foto' => $request['foto'],
            'telepon' => $request['telepon'],
            'alamat' => $request['alamat'],
            'role_id' => 3,
        ]);

        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil ditambahkan');
    }

    // edit
    public function edit(Lecturer $lecturer)
    {
        return view('pages.lecturer.edit', [
            'lecturer' => $lecturer,
            'type_menu' => 'data-master',
        ]);
    }

    // update
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|unique:lecturers,nidn,' . $lecturer->id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:4',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/lecturers');
            $validated['foto'] = Storage::url($path);
        }

        $lecturer->update([
            'nidn' => $request['nidn'],
            'name' => $request['name'],
            'foto' => $request['foto'],
            'telepon' => $request['telepon'],
            'alamat' => $request['alamat'],
        ]);

        if ($request->password) {
            $lecturer->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil diubah');
    }

    // destroy
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil dihapus');
    }
}

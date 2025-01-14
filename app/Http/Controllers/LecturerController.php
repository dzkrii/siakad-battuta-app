<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('role')->get();
        return response()->json($lecturers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|unique:dosens,nidn',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/lecturers');
            $validated['foto'] = Storage::url($path);
        }

        $validated['password'] = Hash::make($validated['password']);

        $lecturer = Lecturer::create($validated);
        return response()->json($lecturer, 201);
    }

    public function show(Lecturer $lecturer)
    {
        return response()->json($lecturer->load('role'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            'nidn' => 'sometimes|required|string|unique:dosens,nidn,' . $lecturer->id,
            'name' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|min:6',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'role_id' => 'sometimes|required|exists:roles,id'
        ]);

        if ($request->hasFile('foto')) {
            if ($lecturer->foto) {
                Storage::delete(str_replace('/storage', 'public', $lecturer->foto));
            }
            $path = $request->file('foto')->store('public/lecturers');
            $validated['foto'] = Storage::url($path);
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $lecturer->update($validated);
        return response()->json($lecturer);
    }

    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->foto) {
            Storage::delete(str_replace('/storage', 'public', $lecturer->foto));
        }
        $lecturer->delete();
        return response()->json(null, 204);
    }
}

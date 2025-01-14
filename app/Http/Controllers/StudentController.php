<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['studyProgram', 'role'])->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim',
            'name' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'angkatan' => 'required|digits:4',
            'status' => 'required|in:aktif,tidak aktif,lulus,cuti',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/students');
            $validated['foto'] = Storage::url($path);
        }

        $validated['password'] = Hash::make($validated['password']);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load(['studyProgram', 'role']));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => 'sometimes|required|string|unique:students,nim,' . $student->id,
            'name' => 'sometimes|required|string|max:255',
            'study_program_id' => 'sometimes|required|exists:study_programs,id',
            'password' => 'sometimes|required|min:6',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'angkatan' => 'sometimes|required|digits:4',
            'status' => 'sometimes|required|in:aktif,tidak aktif,lulus,cuti',
            'role_id' => 'sometimes|required|exists:roles,id'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($student->foto) {
                Storage::delete(str_replace('/storage', 'public', $student->foto));
            }
            $path = $request->file('foto')->store('public/students');
            $validated['foto'] = Storage::url($path);
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $student->update($validated);
        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        if ($student->foto) {
            Storage::delete(str_replace('/storage', 'public', $student->foto));
        }
        $student->delete();
        return response()->json(null, 204);
    }
}

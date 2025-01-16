<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // index
    public function index()
    {
        // search by nim, name, study_program_id, status, pagination 10
        $students = Student::with('studyProgram')
            ->where('nim', 'like', '%' . request('search') . '%')
            ->orWhere('name', 'like', '%' . request('search') . '%')
            ->orWhere('telepon', 'like', '%' . request('search') . '%')
            ->orWhere('alamat', 'like', '%' . request('search') . '%')
            ->orWhere('angkatan', 'like', '%' . request('search') . '%')
            ->orWhere('status', 'like', '%' . request('search') . '%')
            ->orWhereHas('studyProgram', function ($query) {
                $query->where('nama_prodi', 'like', '%' . request('search') . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.student.index', [
            'students' => $students,
            'type_menu' => 'data-master',
        ]);
    }

    // create
    public function create()
    {
        $studyPrograms = StudyProgram::all();
        return view('pages.student.create', [
            'studyPrograms' => $studyPrograms,
            'type_menu' => 'data-master',
        ]);
    }

    // store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim',
            'name' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'password' => 'required|min:4',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'angkatan' => 'required|digits:4',
            'status' => 'required|in:aktif,tidak aktif,lulus,cuti',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/students');
            $validated['foto'] = Storage::url($path);
        }

        Student::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'study_program_id' => $request->study_program_id,
            'password' => Hash::make($request->password),
            'foto' => $request->foto,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'angkatan' => $request->angkatan,
            'status' => $request->status,
            'role_id' => 2
        ]);

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    // edit
    public function edit(Student $student)
    {
        $studyPrograms = StudyProgram::all();
        return view('pages.student.edit', [
            'student' => $student,
            'studyPrograms' => $studyPrograms,
            'type_menu' => 'data-master',
        ]);
    }

    // update
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim,' . $student->id,
            'name' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'password' => 'nullable|min:4',
            'foto' => 'nullable|image|max:2048',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'angkatan' => 'required|digits:4',
            'status' => 'required|in:aktif,tidak aktif,lulus,cuti'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($student->foto) {
                Storage::delete(str_replace('/storage', 'public', $student->foto));
            }
            $path = $request->file('foto')->store('public/students');
            $validated['foto'] = Storage::url($path);
        }

        $student->update([
            'nim' => $request->nim,
            'name' => $request->name,
            'study_program_id' => $request->study_program_id,
            'password' => $request->password ? Hash::make($request->password) : $student->password,
            'foto' => $request->foto,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'angkatan' => $request->angkatan,
            'status' => $request->status
        ]);

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    // destroy
    public function destroy(Student $student)
    {
        // Hapus foto jika ada
        if ($student->foto) {
            Storage::delete(str_replace('/storage', 'public', $student->foto));
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}

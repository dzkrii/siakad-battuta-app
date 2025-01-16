<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    // index
    public function index()
    {
        // search by nama_prodi, pagination 10
        $studyPrograms = StudyProgram::with('faculty')
            ->where('nama_prodi', 'like', '%' . request('search') . '%')
            ->orWhereHas('faculty', function ($query) {
                $query->where('nama_fakultas', 'like', '%' . request('search') . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.study_program.index', [
            'studyPrograms' => $studyPrograms,
            'type_menu' => 'data-master',
        ]);
    }

    // create
    public function create()
    {
        $faculties = Faculty::all(); // Ambil semua data fakultas

        return view('pages.study_program.create', [
            'faculties' => $faculties,
            'type_menu' => 'data-master',
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required',
            'faculty_id' => 'required',
        ]);

        StudyProgram::create([
            'nama_prodi' => $request->nama_prodi,
            'faculty_id' => $request->faculty_id,
        ]);
        return redirect()->route('study_programs.index')->with('success', 'Program studi berhasil ditambahkan');
    }

    // edit
    public function edit(StudyProgram $studyProgram)
    {
        $faculties = Faculty::all();
        return view('pages.study_program.edit', [
            'studyProgram' => $studyProgram,
            'faculties' => $faculties,
            'type_menu' => 'data-master',
        ]);
    }

    // update
    public function update(Request $request, StudyProgram $studyProgram)
    {
        $request->validate([
            'nama_prodi' => 'required',
            'faculty_id' => 'required',
        ]);

        $studyProgram->update([
            'nama_prodi' => $request->nama_prodi,
            'faculty_id' => $request->faculty_id,
        ]);
        return redirect()->route('study_programs.index')->with('success', 'Program studi berhasil diperbarui');
    }

    // destroy
    public function destroy(StudyProgram $studyProgram)
    {
        $studyProgram->delete();
        return redirect()->route('study_programs.index')->with('success', 'Program studi berhasil dihapus');
    }
}

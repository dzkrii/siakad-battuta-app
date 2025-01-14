<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index()
    {
        $studyPrograms = StudyProgram::with('faculty')->get();
        return response()->json($studyPrograms);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $studyProgram = StudyProgram::create($validated);
        return response()->json($studyProgram, 201);
    }

    public function show(StudyProgram $studyProgram)
    {
        return response()->json($studyProgram->load('faculty'));
    }

    public function update(Request $request, StudyProgram $studyProgram)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $studyProgram->update($validated);
        return response()->json($studyProgram);
    }

    public function destroy(StudyProgram $studyProgram)
    {
        $studyProgram->delete();
        return response()->json(null, 204);
    }
}

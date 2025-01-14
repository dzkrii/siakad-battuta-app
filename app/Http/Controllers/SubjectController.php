<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('studyProgram')->get();
        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|unique:subjects,kode_mk',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'study_program_id' => 'required|exists:study_programs,id'
        ]);

        $subject = Subject::create($validated);
        return response()->json($subject, 201);
    }

    public function show(Subject $subject)
    {
        return response()->json($subject->load('studyProgram'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'kode_mk' => 'sometimes|required|string|unique:subjects,kode_mk,' . $subject->id,
            'nama_mk' => 'sometimes|required|string|max:255',
            'sks' => 'sometimes|required|integer|min:1|max:6',
            'study_program_id' => 'sometimes|required|exists:study_programs,id'
        ]);

        $subject->update($validated);
        return response()->json($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(null, 204);
    }
}

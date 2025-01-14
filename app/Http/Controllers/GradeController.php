<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'subject', 'schedule', 'setting'])->get();
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'schedule_id' => 'required|exists:schedules,id',
            'setting_id' => 'required|exists:settings,id',
            'nilai_absensi' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
        ]);

        // Cek apakah nilai untuk mahasiswa ini sudah ada
        $existingGrade = Grade::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('setting_id', $validated['setting_id'])
            ->first();

        if ($existingGrade) {
            return response()->json([
                'message' => 'Nilai untuk mahasiswa ini sudah ada'
            ], 422);
        }

        $grade = Grade::create($validated);
        return response()->json($grade->load(['student', 'subject', 'schedule', 'setting']), 201);
    }

    public function show(Grade $grade)
    {
        return response()->json($grade->load(['student', 'subject', 'schedule', 'setting']));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'nilai_absensi' => 'sometimes|required|numeric|min:0|max:100',
            'nilai_tugas' => 'sometimes|required|numeric|min:0|max:100',
            'nilai_uts' => 'sometimes|required|numeric|min:0|max:100',
            'nilai_uas' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        $grade->update($validated);
        return response()->json($grade->load(['student', 'subject', 'schedule', 'setting']));
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return response()->json(null, 204);
    }

    public function getByStudent($student_id)
    {
        $grades = Grade::with(['student', 'subject', 'schedule', 'setting'])
            ->where('student_id', $student_id)
            ->get();

        return response()->json($grades);
    }

    public function getBySubject($subject_id)
    {
        $grades = Grade::with(['student', 'subject', 'schedule', 'setting'])
            ->where('subject_id', $subject_id)
            ->get();

        return response()->json($grades);
    }

    public function getBySchedule($schedule_id)
    {
        $grades = Grade::with(['student', 'subject', 'schedule', 'setting'])
            ->where('schedule_id', $schedule_id)
            ->get();

        return response()->json($grades);
    }
}

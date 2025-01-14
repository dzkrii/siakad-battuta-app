<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['subject', 'lecturer', 'setting'])->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'setting_id' => 'required|exists:settings,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string'
        ]);

        // Cek jadwal bentrok
        $existingSchedule = Schedule::where('setting_id', $validated['setting_id'])
            ->where('hari', $validated['hari'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                    ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']]);
            })
            ->where(function ($query) use ($validated) {
                $query->where('ruangan', $validated['ruangan'])
                    ->orWhere('lecturer_id', $validated['lecturer_id']);
            })
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'message' => 'Jadwal bentrok dengan jadwal yang sudah ada'
            ], 422);
        }

        $schedule = Schedule::create($validated);
        return response()->json($schedule->load(['subject', 'lecturer', 'setting']), 201);
    }

    public function show(Schedule $schedule)
    {
        return response()->json($schedule->load(['subject', 'lecturer', 'setting']));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'lecturer_id' => 'sometimes|required|exists:lecturers,id',
            'setting_id' => 'sometimes|required|exists:settings,id',
            'hari' => 'sometimes|required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'sometimes|required|date_format:H:i',
            'jam_selesai' => 'sometimes|required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'sometimes|required|string'
        ]);

        // Cek jadwal bentrok kecuali dengan jadwal ini sendiri
        if (
            isset($validated['jam_mulai']) || isset($validated['jam_selesai']) ||
            isset($validated['hari']) || isset($validated['ruangan']) ||
            isset($validated['lecturer_id'])
        ) {

            $jam_mulai = $validated['jam_mulai'] ?? $schedule->jam_mulai;
            $jam_selesai = $validated['jam_selesai'] ?? $schedule->jam_selesai;
            $hari = $validated['hari'] ?? $schedule->hari;
            $ruangan = $validated['ruangan'] ?? $schedule->ruangan;
            $lecturer_id = $validated['lecturer_id'] ?? $schedule->lecturer_id;

            $existingSchedule = Schedule::where('setting_id', $schedule->setting_id)
                ->where('id', '!=', $schedule->id)
                ->where('hari', $hari)
                ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                    $query->whereBetween('jam_mulai', [$jam_mulai, $jam_selesai])
                        ->orWhereBetween('jam_selesai', [$jam_mulai, $jam_selesai]);
                })
                ->where(function ($query) use ($ruangan, $lecturer_id) {
                    $query->where('ruangan', $ruangan)
                        ->orWhere('lecturer_id', $lecturer_id);
                })
                ->first();

            if ($existingSchedule) {
                return response()->json([
                    'message' => 'Jadwal bentrok dengan jadwal yang sudah ada'
                ], 422);
            }
        }

        $schedule->update($validated);
        return response()->json($schedule->load(['subject', 'lecturer', 'setting']));
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(null, 204);
    }

    public function getByDay($day)
    {
        $schedules = Schedule::with(['subject', 'lecturer', 'setting'])
            ->where('hari', ucfirst($day))
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($schedules);
    }

    public function getByLecturer($lecturer_id)
    {
        $schedules = Schedule::with(['subject', 'lecturer', 'setting'])
            ->where('lecturer_id', $lecturer_id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($schedules);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    // Menampilkan semua fakultas
    public function index()
    {
        $faculties = Faculty::all();

        return response()->json([
            'success' => true,
            'data' => $faculties,
        ]);
    }

    // Menyimpan fakultas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|unique:faculties,nama_fakultas|max:100',
        ]);

        $faculty = Faculty::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fakultas berhasil ditambahkan',
            'data' => $faculty,
        ]);
    }

    // Menampilkan fakultas berdasarkan ID
    public function show($id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json([
                'success' => false,
                'message' => 'Fakultas tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $faculty,
        ]);
    }

    // Mengupdate fakultas
    public function update(Request $request, $id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json([
                'success' => false,
                'message' => 'Fakultas tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'nama_fakultas' => 'required|unique:faculties,nama_fakultas,' . $id . '|max:100',
        ]);

        $faculty->update([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fakultas berhasil diupdate',
            'data' => $faculty,
        ]);
    }

    // Menghapus fakultas
    public function destroy($id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json([
                'success' => false,
                'message' => 'Fakultas tidak ditemukan',
            ], 404);
        }

        $faculty->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fakultas berhasil dihapus',
        ]);
    }
}

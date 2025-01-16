<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        $faculties = Faculty::latest()->paginate(10);

        return view('admin.fakultas.index', compact('faculties'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_fakultas' => 'required|unique:faculties,nama_fakultas|max:100',
        ]);

        // Simpan data fakultas
        Faculty::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }
}

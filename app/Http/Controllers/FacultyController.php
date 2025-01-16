<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    // index
    public function index()
    {
        // search by nama_fakultas, pagination 10
        $faculties = Faculty::where('nama_fakultas', 'like', '%' . request('search') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.fakultas.index', [
            'faculties' => $faculties,
            'type_menu' => 'data-master',
        ]);
    }

    // create
    public function create()
    {
        return view('pages.fakultas.create', [
            'type_menu' => 'data-master',
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required',
        ]);

        Faculty::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);
        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil ditambahkan');
    }

    // edit
    public function edit(Faculty $faculty)
    {
        return view('pages.fakultas.edit', [
            'faculty' => $faculty,
            'type_menu' => 'data-master',
        ]);
    }

    // update
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'nama_fakultas' => 'required',
        ]);

        $faculty->update([
            'nama_fakultas' => $request->nama_fakultas,
        ]);
        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil diperbarui');
    }

    // destroy
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil dihapus');
    }
}

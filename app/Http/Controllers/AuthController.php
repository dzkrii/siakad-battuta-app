<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('pages.auth.admin.auth-login');
    }

    public function showMahasiswaLoginForm()
    {
        return view('pages.auth.mahasiswa.auth-login');
    }

    public function showDosenLoginForm()
    {
        return view('pages.auth.dosen.auth-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); // Ganti dengan rute dashboard Anda  
        }

        return back()->withErrors([
            'credentials' => 'Credential salah.',
        ]);
    }

    public function mahasiswaLogin(Request $request)
    {
        $credentials = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('mahasiswa.dashboard'); // Ganti dengan rute dashboard Anda  
        }

        return back()->withErrors([
            'credentials' => 'Credential salah.',
        ]);
    }

    public function dosenLogin(Request $request)
    {
        $credentials = $request->validate([
            'nidn' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('lecturer')->attempt($credentials)) {
            return redirect()->route('dosen.dashboard'); // Ganti dengan rute dashboard Anda  
        }

        return back()->withErrors([
            'credentials' => 'Credential salah.',
        ]);
    }
}

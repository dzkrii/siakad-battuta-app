<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dosen.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nidn' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'nidn' => $request->nidn,
            'password' => $request->password
        ];

        if (Auth::guard('lecturer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dosen.dashboard');
        }

        return back()->withErrors([
            'nidn' => 'NIDN atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::guard('lecturer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dosen.login');
    }
}

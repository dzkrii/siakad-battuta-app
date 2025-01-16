<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah admin terautentikasi  
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Cek apakah mahasiswa terautentikasi  
        if (Auth::guard('student')->check()) {
            return $next($request);
        }

        // Cek apakah dosen terautentikasi  
        if (Auth::guard('lecturer')->check()) {
            return $next($request);
        }

        // Jika tidak terautentikasi, maka redirect ke halaman login masing - masing
        if ($request->is('login/admin')) {
            return redirect()->route('admin.login');
        } elseif ($request->is('login/mahasiswa')) {
            return redirect()->route('mahasiswa.login');
        } elseif ($request->is('login/dosen')) {
            return redirect()->route('dosen.login');
        }

        // Jika tidak terautentikasi, maka redirect ke halaman login mahasiswa
        return redirect()->route('mahasiswa.login');
    }
}

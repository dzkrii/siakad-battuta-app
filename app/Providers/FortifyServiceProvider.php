<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // View responses untuk login forms
        Fortify::loginView(function (Request $request) {
            $guard = $request->route()->getName();

            if ($guard === 'admin.login') {
                return view('pages.auth.admin.auth-login');
            } elseif ($guard === 'student.login') {
                return view('pages.auth.mahasiswa.auth-login');
            } elseif ($guard === 'lecturer.login') {
                return view('pages.auth.dosen.auth-login');
            }
        });

        Fortify::authenticateUsing(function (Request $request) {
            // Determine which guard to use based on the route
            $guard = $request->route()->getName();

            if ($guard === 'admin.login') {
                $user = Admin::where('username', $request->username)->first();
                $credentials = [
                    'username' => $request->username,
                    'password' => $request->password,
                ];
            } elseif ($guard === 'student.login') {
                $user = Student::where('nim', $request->nim)->first();
                $credentials = [
                    'nim' => $request->nim,
                    'password' => $request->password,
                ];
            } elseif ($guard === 'lecturer.login') {
                $user = Lecturer::where('nidn', $request->nidn)->first();
                $credentials = [
                    'nidn' => $request->nidn,
                    'password' => $request->password,
                ];
            }

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });
    }
}

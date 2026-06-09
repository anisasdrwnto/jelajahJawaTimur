<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login.index');
    }

    
    public function login(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        if (Auth::attempt(['mus_email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Return JSON kalau request dari AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Login berhasil!',
                    'redirect' => route('dashboard'),
                ]);
            }

            return redirect()->intended(route('dashboard'));
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    public function handleGoogleCallback(){
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['mus_email' => $googleUser->getEmail()],
                [
                    'mus_id_users'      => 'USR-' . strtoupper(Str::random(8)),
                    'mus_name'          => $googleUser->getName(),
                    'mus_email'         => $googleUser->getEmail(),
                    'mus_foto_profile'  => $googleUser->getAvatar(),
                    'mus_password'      => bcrypt(Str::random(16)),
                    'mus_role'          => 'USR',
                    'mus_createBy'      => 'Google',
                    'mus_createDate'    => now(),
                ]
            );

       

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal. Silakan coba lagi.',
            ]);
        }
    }
}
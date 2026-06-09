<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('register.index');
    }

    public function register(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:mst_users,mus_email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'mus_id_users'   => 'USR-' . strtoupper(Str::random(8)),
            'mus_name'       => $request->name,
            'mus_email'      => $request->email,
            'mus_password'   => Hash::make($request->password),
            'mus_createBy'   => 'System',
            'mus_createDate' => now(),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
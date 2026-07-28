<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->withInput(
                    $request->only('email')
                );

        }


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION & RECORD LOGIN LOG
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        try {
            if (Auth::user()->role !== 'admin') {
                \App\Models\UserLoginLog::create([
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role ?? 'user',
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                    'logged_in_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Ignore log creation errors to prevent blocking login
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */


        if (Auth::user()->role === 'admin') {

            return redirect()->route(
                'admin.dashboard'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | USER DASHBOARD
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'user.dashboard'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | BUAT USER BARU
        |--------------------------------------------------------------------------
        |
        | Setiap akun yang mendaftar melalui halaman Register
        | otomatis menjadi USER.
        |
        */

        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => 'user',

        ]);


        /*
        |--------------------------------------------------------------------------
        | LOGIN OTOMATIS SETELAH REGISTER
        |--------------------------------------------------------------------------
        */

        Auth::login($user);


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION & RECORD LOGIN LOG
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        try {
            \App\Models\UserLoginLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'user',
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                'logged_in_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Ignore log creation errors to prevent blocking registration
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT KE USER DASHBOARD
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'user.dashboard'
        )->with(
            'success',
            'Akun berhasil dibuat. Selamat datang!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | LOGOUT USER
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | INVALIDATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();


        /*
        |--------------------------------------------------------------------------
        | REGENERATE CSRF TOKEN
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'login'
        )->with(
            'success',
            'Anda berhasil logout.'
        );
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_telp' => ['required', 'string', 'max:15'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'Pasien', // FIX: lowercase
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat!');
    }

    public function index()
    {
        return view('auth.login');
    }

        public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Gunakan redirect eksplisit, BUKAN intended()
            // intended() bisa mengarah ke URL lama yang salah
            return match(Auth::user()->role) {
                'Admin'    => redirect('/admin/dashboard'),
                'Dokter'   => redirect('/dokter/dashboard'),
                'Pasien'   => redirect('/pasien/dashboard'),
                'Apoteker' => redirect('/apoteker/dashboard'),
                default    => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function checkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return redirect()->route('password.reset', ['email' => $request->email]);
        }

        return back()->withErrors(['email' => 'Email tidak terdaftar di sistem kami.']);
    }

    public function showResetForm($email) {
        return view('auth.forgot-reset', ['email' => $email]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect('/login')->with('success', 'Password berhasil diperbarui. Silakan login.');
        }

        return redirect('/login')->with('error', 'Terjadi kesalahan.');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
            'role' => 'pasien', // Tetap dikunci sebagai pasien
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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data role user yang sedang login
            $role = Auth::user()->role; 

            // Arahkan ke dashboard masing-masing sesuai role
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'dokter') {
                return redirect()->intended('/dokter/dashboard');
            } elseif ($role === 'pasien') {
                return redirect()->intended('/pasien/dashboard');
            } elseif ($role === 'apoteker') {
                return redirect()->intended('/apoteker/dashboard');
            }

            // Default jika role tidak dikenali
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function checkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Jika email ada, pindah ke form Gambar 2 sambil membawa email-nya
            return redirect()->route('password.reset', ['email' => $request->email]);
        }

        return back()->withErrors(['email' => 'Email tidak terdaftar di sistem kami.']);
    }

    public function showResetForm($email) {
        return view('auth.forgot-reset', ['email' => $email]); // Gambar 2
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('desas.login');
    }
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Validasi Role: Pastikan hanya role admin yang boleh masuk
        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->with('error', 'Akses ditolak! Halaman ini khusus Administrator.');
        }

        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->with('error', 'Email atau password salah.');
}

    // Memproses Login DAN Registrasi dalam 1 Method
    public function authenticate(Request $request)
    {
        // 1. JIKA USER MENEKAN TOMBOL DAFTAR (Pendaftaran Baru)
        if ($request->input('action') === 'register') {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'banom'    => 'nullable|string|in:ipnu,banser,muslimat,fatayat',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'email.unique'       => 'Email ini sudah terdaftar. Silakan gunakan email lain atau pilih tab Masuk.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min'       => 'Password minimal berisi 6 karakter.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('tab', 'register');
            }

            // Buat user baru dengan role default 'user'
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'banom'    => $request->banom ?? null,
                'password' => Hash::make($request->password),
                'role'     => 'user', // Default role untuk pendaftar umum
            ]);

            Auth::login($user);

            return redirect()->route('desas.index')->with('success', 'Pendaftaran berhasil! Selamat datang di Portal.');
        }

        // 2. JIKA USER MENEKAN TOMBOL MASUK (Login)
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek status role untuk pesan selamat datang
            $roleUser = auth()->user()->role === 'admin' ? 'Administrator' : 'Anggota';

            return redirect()->intended(route('desas.index'))
                             ->with('success', "Selamat datang kembali, {$roleUser}!");
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('desas.index')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
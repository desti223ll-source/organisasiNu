<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnggotaController;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIK (Bisa Diakses Bebas Tanpa Login)
|--------------------------------------------------------------------------
*/
// Halaman Utama Berita & Detail
Route::get('/', [DesaController::class, 'index'])->name('desas.index');
Route::get('/warta/{desa}', [DesaController::class, 'show'])->name('desas.show');

// Halaman Organisasi & Anggota (Hanya Lihat/Read-Only)
Route::get('/struktur', [DesaController::class, 'struktur'])->name('desas.struktur');
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/anggota/{anggota}', [AnggotaController::class, 'show'])->name('anggota.show');


/*
|--------------------------------------------------------------------------
| 2. ROUTE LOGIN & REGISTER (Hanya Pengunjung yang BELUM Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Halaman Form Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    
    // Proses Autentikasi Login
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
    
    // Proses Pendaftaran Akun Baru (Data tersimpan & langsung muncul di data.blade.php)
    Route::post('/register', [AnggotaController::class, 'store'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
| 3. ROUTE LOGOUT & CETAK KTA (Pengguna yang SUDAH Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Cetak KTA (Dapat diakses dari Profil Modal di index.blade.php / data.blade.php)
    Route::get('/anggota/{id}/cetak', [AnggotaController::class, 'cetak'])->name('anggota.cetak');
});


/*
|--------------------------------------------------------------------------
| 4. ROUTE KHUSUS ADMIN (Hanya Bisa Dibuka oleh Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Kelola Berita / Warta (Tambah, Simpan, Edit, Update, Hapus)
    Route::resource('desas', DesaController::class)->except(['index', 'show']); 
    
    // Kelola Data Anggota (Tambah, Edit, Update, Hapus)
    Route::resource('anggota', AnggotaController::class)->except(['index', 'show']);

});
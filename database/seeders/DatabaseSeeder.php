<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin tetap/default
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@portalnu.or.id')], // Cek jika email sudah ada
            [
                'name'     => env('ADMIN_NAME', 'Admin Utama'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'PasswordAdmin123!')), // Wajib di-hash
                'role'     => 'admin', // Menandakan bahwa ini akun admin
            ]
        );
    }
}
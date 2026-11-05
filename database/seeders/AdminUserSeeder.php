<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk memasukkan akun admin utama.
     */
    public function run(): void
    {
        $adminData = [
            'name' => 'Admin EduSafe',
            'email' => 'admin@edusafe.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // 1. Simpan atau perbarui di tabel `users` (tabel autentikasi Laravel)
        $user = User::updateOrCreate(
            ['email' => $adminData['email']],
            $adminData
        );

        // 2. Simpan atau perbarui di tabel `user` (tabel database legacy jika ada)
        if (Schema::hasTable('user')) {
            try {
                DB::table('user')->updateOrInsert(
                    ['email' => $adminData['email']],
                    [
                        'username' => $adminData['name'],
                        'password' => $user->password,
                        'role' => 'admin',
                        'jumlahGagalLogin' => 0,
                        'waktuKunci' => null,
                        'created_at' => now(),
                    ]
                );
            } catch (\Throwable $e) {
                // Abaikan jika ada kegagalan sinkronisasi tabel legacy
            }
        }
    }
}


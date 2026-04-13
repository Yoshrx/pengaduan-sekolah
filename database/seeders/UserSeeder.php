<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Mengisi tabel users dengan data awal:
     * - 1 Admin sekolah
     * - 3 Siswa demo dengan NIS dan kelas
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Sekolah',
            'username' => 'admin',
            'email'    => 'admin@sekolah.test',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Siswa - data demo
        $siswas = [
            [
                'name'     => 'Budi Santoso',
                'username' => 'siswa1',
                'nis'      => '2024001',
                'kelas'    => 'XII RPL 1',
                'email'    => 'budi@sekolah.test',
                'password' => Hash::make('siswa123'),
                'role'     => 'siswa',
            ],
            [
                'name'     => 'Siti Rahayu',
                'username' => 'siswa2',
                'nis'      => '2024002',
                'kelas'    => 'XII RPL 2',
                'email'    => 'siti@sekolah.test',
                'password' => Hash::make('siswa123'),
                'role'     => 'siswa',
            ],
            [
                'name'     => 'Andi Pratama',
                'username' => 'siswa3',
                'nis'      => '2024003',
                'kelas'    => 'XII RPL 1',
                'email'    => 'andi@sekolah.test',
                'password' => Hash::make('siswa123'),
                'role'     => 'siswa',
            ],
        ];

        foreach ($siswas as $siswa) {
            User::create($siswa);
        }
    }
}

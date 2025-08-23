<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 0 => Admin
        // 1 => Kasubag
        // 2 => Staff TU
        // 3 => Satpam
        // 4 => Pegawai BPN
        User::insert([
            [
                'id_pegawai' => 1,
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => '0',
            ],
            [
                'id_pegawai' => 2,
                'username' => 'pegawai',
                'password' => Hash::make('admin123'),
                'role' => '4',
            ],
            [
                'id_pegawai' => 3,
                'username' => 'staff',
                'password' => Hash::make('admin123'),
                'role' => '2',
            ],
            [
                'id_pegawai' => 4,
                'username' => 'pegawai II',
                'password' => Hash::make('admin123'),
                'role' => '4',
            ],
            [
                'id_pegawai' => 5,
                'username' => 'satpam',
                'password' => Hash::make('admin123'),
                'role' => '3',
            ],
            [
                'id_pegawai' => 6,
                'username' => 'kasubag',
                'password' => Hash::make('admin123'),
                'role' => '1',
            ],
        ]);
    }
}

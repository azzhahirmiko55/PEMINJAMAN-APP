<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
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
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id_pegawai' => 1,
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => '0',
        ]);
    }
}

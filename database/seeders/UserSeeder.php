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
            'username' => 'kepala_kantor',
            'fullname' => 'kepala_kantor sistem',
            'password' => Hash::make('kepalakantor_1234'),
        ]);
    }
}

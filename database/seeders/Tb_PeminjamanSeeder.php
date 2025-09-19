<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tb_Peminjaman;

class Tb_PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tb_Peminjaman::factory()->count(100)->create();
    }
}
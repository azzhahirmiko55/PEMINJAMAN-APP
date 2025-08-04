<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         foreach (range(1, 5) as $i) {
            DB::table('tb_ruang_rapat')->insert([
                'nama_ruangan' => 'Aula ' . $i,
                'warna_ruangan' => null,
                'active_st' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

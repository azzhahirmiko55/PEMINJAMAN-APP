<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warnaList = ['Hitam', 'Putih', 'Merah', 'Biru', 'Abu-abu', 'Hijau', 'Kuning'];
        $huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $generatePlat = function () use ($huruf) {
            $depan = Str::upper(Str::random(1)); // misalnya B
            $angka = rand(100, 9999); // 3–4 digit angka
            $belakang = strtoupper(substr(str_shuffle($huruf), 0, rand(1, 3))); // huruf 1–3
            return $depan . ' ' . $angka . ' ' . $belakang;
        };

        $data = [];

        // Tambahkan 10 mobil
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'no_plat' => $generatePlat(),
                'jenis_kendaraan' => 'Roda-4',
                'warna_kendaraan' => $warnaList[array_rand($warnaList)],
                'keterangan' => 'Mobil dinas',
                'active_st' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Tambahkan 5 motor
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'no_plat' => $generatePlat(),
                'jenis_kendaraan' => 'Roda-2',
                'warna_kendaraan' => $warnaList[array_rand($warnaList)],
                'keterangan' => 'Motor operasional',
                'active_st' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tb_kendaraan')->insert($data);
    }
}

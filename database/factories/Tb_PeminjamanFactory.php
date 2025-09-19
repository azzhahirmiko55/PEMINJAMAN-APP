<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Tb_PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipe = $this->faker->randomElement(['kendaraan', 'ruangan']);
        $start = $this->faker->dateTimeBetween('2025-09-01 08:00:00', '2025-09-30 17:00:00');
        $end   = (clone $start)->modify('+'.rand(2,5).' hours');

        return [
            'id_peminjam' => $this->faker->numberBetween(1, 5),
            'id_kendaraan' => $tipe === 'kendaraan' ? $this->faker->numberBetween(1, 5) : null,
            'id_ruangan' => $tipe === 'ruangan' ? $this->faker->numberBetween(1, 5) : null,
            'id_verifikator' => $this->faker->numberBetween(1, 3),
            'tipe_peminjaman' => $tipe,
            'tanggal' => $start->format('Y-m-d'),
            'jam_mulai' => $start,
            'jam_selesai' => $end,
            'keperluan' => $this->faker->sentence(5),
            'keperluan_bbm' => $tipe === 'kendaraan' ? $this->faker->sentence(3) : null,
            'driver' => $tipe === 'kendaraan' ? $this->faker->name() : null,
            'jumlah_peserta' => $tipe === 'ruangan' ? (string)$this->faker->numberBetween(5, 20) : null,
            'status' => $this->faker->numberBetween(-1, 1),
            'active_st' => true,
            'verifikator_catatan' => $this->faker->sentence(4),
            'verifikator_tgl' => $this->faker->dateTimeBetween('2025-09-01', '2025-09-12'),
            'pengembalian_st' => $this->faker->boolean(),
            'pengembalian_tgl' => $this->faker->optional()->dateTimeBetween('2025-09-05', '2025-09-12'),
            'pengembalian_pegawai_id' => $this->faker->optional()->numberBetween(1, 5),
            'pengembalian_catatan' => $this->faker->optional()->sentence(4),
            'detail_lokasi' => $this->faker->randomElement(['desa', 'kota']),
        ];
    }
}
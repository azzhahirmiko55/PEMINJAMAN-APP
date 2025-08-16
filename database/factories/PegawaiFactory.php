<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_pegawai' => $this->faker->name(),
            'jabatan' => $this->faker->randomElement(['Kasubag', 'Pegawai BPN', 'Staff TU', 'Security']),
            'jenis_kelamin' => $this->faker->randomElement([0,1]),
            'active_st' => true,
        ];
    }
}

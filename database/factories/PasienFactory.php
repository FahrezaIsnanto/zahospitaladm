<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasienFactory extends Factory
{
    protected $model = Pasien::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_pasien' => $this->faker->name(),
            'alamat_pasien' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber()
        ];
    }
}

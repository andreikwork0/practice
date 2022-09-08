<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'            => rand(10, 15),
            'num_agreement'         => $this->faker->numerify('#####/д'),
            'date_agreement'        => $this->faker->dateTime(),
            'date_bg'               => $this->faker->dateTime(),
            'date_end'              => $this->faker->dateTime(),
            'is_actual'             => rand(0, 1),
        ];
    }
}

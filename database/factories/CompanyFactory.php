<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'legal_adress' => $this->faker->address(),
            'fact_adress' => $this->faker->address(),
            'mng_surname' => $this->faker->lastName(),
            'mng_name' => $this->faker->firstName(),
            'mng_patronymic' => $this->faker->middleName(),
            'inn' => $this->faker->numerify('#########'),
            'kpp' => $this->faker->numerify('###########'),
            'ch_account' => $this->faker->numerify('#######################################'),
            'cr_account' => $this->faker->numerify('###################### '),
            'bik' => $this->faker->numerify('#############'),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'company_id'    => rand(10, 15),
        'prs_rule'      => $this->faker->jobTitle(),
        'prs_lname'     => $this->faker->lastName(),
        'prs_fname'     => $this->faker->firstName(),
        'prs_sname'     => $this->faker->middleName(),
        'prs_job'       => $this->faker->jobTitle(),
        'prs_office'    => $this->faker->word(),
        'is_negotiation' => rand(0, 1),
        ];

    }
}

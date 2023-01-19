<?php

namespace Database\Factories;

use App\Models\OrgStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrgStructureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->word(),
            'name_short'        => $this->faker->word(),
            'company_id'        =>  2//rand(2, 3),
        ];
    }
}

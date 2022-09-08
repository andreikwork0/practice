<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GrnLetterFactory extends Factory
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
            'num_letter'            => $this->faker->numerify('#####/п'),
            'date_letter'           => $this->faker->dateTime(),
            'note_letter'           => $this->faker->paragraph()
        ];
    }
}
//$table->id();
//
//$table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
//
//$table->string('num_letter',30);
//$table->dateTime('date_letter', 4);
//
//$table->string('note_letter',300);

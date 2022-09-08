<?php

namespace Database\Seeders;

use App\Models\GrnLetter;
use Illuminate\Database\Seeder;

class GrnLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrnLetter::factory(30)->create();
    }
}

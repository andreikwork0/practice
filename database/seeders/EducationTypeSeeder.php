<?php

namespace Database\Seeders;

use App\Models\EducationType;
use Illuminate\Database\Seeder;

class EducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationType::create([
            'name'          => 'Высшее образование',
            'short_name'    => 'ВО',
            'slug'          => 'vo',
        ]);

        EducationType::create([
            'name'          => 'Среднее профессиональное образование',
            'short_name'    => 'СПО',
            'slug'          => 'spo',
        ]);
    }
}

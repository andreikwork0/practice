<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\ContactPerson;
use App\Models\Practice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       $this->call([
            CompanySeeder::class,
            ContactPersonSeeder::class,
            AgreementSeeder::class,
            GrnLetterSeeder::class,
            EducationTypeSeeder::class,
            YearLearningSeeder::class,
            PracticeSeeder::class,
       ]);
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

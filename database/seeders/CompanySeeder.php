<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();
        Company::factory(20)->create();
        Company::factory(5)->create(
            ['parent_id' => rand(10,20)]
        );
        Company::factory(5)->create(
            ['parent_id' => rand(10,20)]
        );
    }
}

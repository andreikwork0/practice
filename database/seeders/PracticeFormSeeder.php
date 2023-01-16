<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\PracticeForm;
use Illuminate\Database\Seeder;

class PracticeFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PracticeForm::create([
            'name' => 'дискретная'
        ]);

        PracticeForm::create([
            'name' => 'непрерывная'
        ]);
    }
}

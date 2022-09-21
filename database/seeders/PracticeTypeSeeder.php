<?php

namespace Database\Seeders;

use App\Models\PracticeType;
use Illuminate\Database\Seeder;

class PracticeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $args = array(
            array(
               'name' => 'Концентрированная',
               'short_name' => 'к',
            ),
            array(
                'name' => 'Распределенная',
                'short_name' => 'р',
            ),
        );

        foreach ($args as  $arg){
            PracticeType::create($arg);
        }


    }
}

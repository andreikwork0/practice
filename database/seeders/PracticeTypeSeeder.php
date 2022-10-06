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
               'name' => 'Учебная практика',
               'short_name' => 'У',
            ),
            array(
                'name' => 'Производственная практика',
                'short_name' => 'П',
            ),
            array(
                'name' => 'Преддипломная практика',
                'short_name' => 'Пд',
            ),
        );

        foreach ($args as  $arg){
            PracticeType::create($arg);
        }


    }
}

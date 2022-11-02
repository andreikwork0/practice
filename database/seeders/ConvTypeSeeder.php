<?php

namespace Database\Seeders;

use App\Models\Convention;
use App\Models\ConvType;
use Illuminate\Database\Seeder;

class ConvTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $args = array(
            [
                'name'      => 'образовательные',
                'template'  => 'convention_edu.docx',
            ],
            [
                'name'      => 'помещения',
                'template'  => 'convention_prem.docx',
            ],
            [
                'name'      => 'другие',
                'template'  => 'convention_oth.docx',
            ],
        );


        foreach ($args as $arg ) {
            ConvType::create($arg);
        }

    }
}

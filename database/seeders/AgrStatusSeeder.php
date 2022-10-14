<?php

namespace Database\Seeders;

use App\Models\AgrStatus;
use Illuminate\Database\Seeder;

class AgrStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = array(
          'Составляется', 'Согласуется', 'Подписывается', 'Подписан'
        );

        foreach ($statuses as $status){
            AgrStatus::create([
                'name' => $status
            ]);
        }

    }
}

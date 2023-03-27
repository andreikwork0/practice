<?php

namespace Database\Seeders;

use App\Models\Agreement;
use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tool::factory(300)->create();
    }
}

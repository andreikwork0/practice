<?php

namespace Database\Seeders;

use App\Models\ContactPerson;
use Illuminate\Database\Seeder;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ContactPerson::truncate();
        ContactPerson::factory(100)->create();

    }
}

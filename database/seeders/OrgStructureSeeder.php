<?php

namespace Database\Seeders;

use App\Models\OrgStructure;
use Illuminate\Database\Seeder;

class OrgStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        OrgStructure::factory(3)->create();

        OrgStructure::factory(10)->create()
            ->each(function ($org){
                $org->org_structure_id = OrgStructure::where('is_active','=','1')
                    ->where('id','<>',$org->id)->get()->random()->id;
                $org->save();
            });

        OrgStructure::factory(20)->create()
            ->each(function ($org){
                $org->org_structure_id = OrgStructure::where('is_active','=','1')
                    ->where('id','<>',$org->id)->get()->random()->id;
                $org->save();
            });

        OrgStructure::factory(30)->create()
            ->each(function ($org){
                $org->org_structure_id = OrgStructure::where('is_active','=','1')
                                                    ->where('id','<>',$org->id)->get()->random()->id;
                $org->save();
            });



    }
}

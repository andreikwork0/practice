<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json = File::get("database/data/oksm.json");
        $countries = json_decode($json);

        foreach ($countries->countries as $key => $value) {
            $args = array(
                "name" => $value->name,
                "code" => $value->code,
            );

            if (!empty($value->name_full)){
                $args['name_full'] = $value->name_full;
            }
            if (!empty($value->alpha_2)){
                $args['alpha_2'] = $value->alpha_2;
            }
            if (!empty($value->alpha_3)){
                $args['alpha_3'] = $value->alpha_3;
            }

            Country::create($args);
        }
    }
}

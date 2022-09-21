<?php

namespace Database\Seeders;

use App\Models\YearLearning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearLearningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->mySeed('mysql_load',  1);
        $this->mySeed('mysql_load_spo',  2);


    }
    private function mySeed($connection = 'mysql_load', $education_type_id = 1 ){

        $sq1 = "SELECT * FROM year_learning  WHERE  active = 'y'";

        foreach (YearLearning::all() as $ylearns){
            $ylearns->active = 0;
            $ylearns->save();
        }

        $year_learning = DB::connection($connection)->select($sq1);

        $year_learning = $year_learning[0];

        $cur_year =  YearLearning::where(
            ['year' => $year_learning->year ]
        )->get();


        if (count($cur_year)> 0){
            $cur_year =  $cur_year[0];
        } else {
            $cur_year = false;
        }

        $args = [];
        if ($education_type_id  == 1){
            $args['l_id_vo'] =  $year_learning->id;
        }
        else     {
            $args['l_id_spo'] =  $year_learning->id;
        }



        if  ($cur_year){
            $cur_year->active = 1;
            if ($education_type_id  == 1){
                $cur_year->l_id_vo =  $year_learning->id;
            }
            else     {
                $cur_year->l_id_spo =  $year_learning->id;
            }
            $cur_year->save();
        }
        else  {
            // create
            YearLearning::create( array_merge([
               'year'       =>  $year_learning->year,
                'active'    => 1,
            ], $args));
        }


    }
}

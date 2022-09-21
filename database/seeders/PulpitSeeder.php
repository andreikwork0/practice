<?php

namespace Database\Seeders;

use App\Models\Pulpit;
use App\Models\YearLearning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PulpitSeeder extends Seeder
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
    private function mySeed($connection = 'mysql_load', $education_type_id = 1 )
    {

        $sql = "SELECT *  FROM pulpit as p WHERE  p.id_year_learning  = :year";
        $year_learning = YearLearning::activeYear();

        $id_year_load = 0;
        if ($education_type_id == 1){
            $id_year_load = $year_learning->l_id_vo;
        } else {
            $id_year_load = $year_learning->l_id_spo;
        }


        $pulpits = DB::connection($connection)->select($sql, ["year" => $id_year_load ]);
        foreach( $pulpits as $pulpit){
            $tmp_pulpit = array(
                "name"                  =>  $pulpit->name,
                "education_type_id"     =>  $education_type_id,
                "year_learning_id"      =>  $year_learning->id,
                "l_pulpit_id"           =>  $pulpit->id,
                "code"                  =>  $pulpit->code
            );
            Pulpit::create($tmp_pulpit );
        }

    }
}

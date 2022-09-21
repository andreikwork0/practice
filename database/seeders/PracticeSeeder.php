<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\YearLearning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PracticeSeeder extends Seeder
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

        $year_learning = YearLearning::activeYear();

        $years = explode('-', $year_learning->year );

        if ($education_type_id ==  1) {
            $day_sql = "pp.day as day,";
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            $day_sql = "";
            $id_year_learning = $year_learning->l_id_spo;
        }
        //var_dump($years);

        //var_dump($year_learning->id_spo);


        $sql2 = "
        SELECT
       pp.id as l_pr_plan_id,
       pp.type as type,
       pp.name as name,
       pt.name as plan_title,
       pp.course as course,
       pp.semester as semester,".$day_sql."

       pp.week as week,


       concat(dr.code, ' ', dr.name, ' ', pf.name) as spec,

       concat(gr.name, '-', gr.year, '-',gr.number) as agroup,
       gr.contingent as  contingent,

       gr.id_year_learning as  id_year_learning,
       pp.id_pulpit as id_pulpit,
       pp.id_plan as id_plan

    FROM plan_practice pp
        join ( groups gr join (profile pf join direction dr on pf.id_direction=dr.id)
        on gr.id_profile=pf.id) on pp.id_plan =gr.id_plan
        join plan_title pt on pp.id_plan = pt.id
    where gr.id_year_learning=".$id_year_learning."
        and (pp.type in ('p', 'l') )
        and (pt.year_begin + pp.course) =  :year_f
    order by pp.id_plan;";



        $practices = DB::connection($connection)->select($sql2, ["year_f" => $years[1] ]);
        $pr_arr = [];
        foreach( $practices as $practice){
            $tmp_practice = (array)$practice;
            $tmp_practice['education_type_id']  = $education_type_id; // vo
            $tmp_practice['id_year_learning'] =  $year_learning->id;
            Practice::create($tmp_practice );
        }


        // проставить даты
    }

}

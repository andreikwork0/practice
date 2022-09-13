<?php

namespace Database\Seeders;

use App\Models\Practice;
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

        $sq1 = "SELECT *
            FROM year_learning
            WHERE  active = 'y'
            ";


        $year_learning = DB::connection('mysql_load')->select($sq1);

        $years = explode('-', $year_learning[0]->year );



        $sql2 = "SELECT
       pp.type as type,
       pp.name as name,
       pt.name as plan_title,
       pp.course as course,
       pp.semester as semester,

       pp.day as day,
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
where gr.id_year_learning=(select max(year_learning.id) from year_learning)
    and (pp.type in ('p', 'l') )
    and (pt.year_begin + pp.course) =  :year_f
order by pp.id_plan;";


        $practices = DB::connection('mysql_load')->select($sql2, ["year_f" => $years[1]]);
        $pr_arr = [];
        foreach( $practices as $practice){
            Practice::create( (array)$practice);
        }


        // проставить даты

    }
}

<?php

namespace App\Import;

use App\Models\Practice;
use App\Models\Teacher;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class SubscribeTeacherPractice
{


    protected $settings;
    public function __construct($settings = [])
    {
        if (empty($settings)) {
            $settings = array(
                ['connection' => 'mysql_load',
                    'ed_type' =>    1 ],
                ['connection' => 'mysql_load_spo',
                    'ed_type' =>    2 ],
            );
        }
        $this->settings = $settings;
    }

    public  function run()
    {
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
        }
    }



    private function import($connection, $ed_type){
         $practices = Practice::query()->filter(['pr_state' => 'n', 'ed_type' => $ed_type])->get(); // 'n'  и  с текущим годом
        foreach ($practices as $practice) {
            $sql ="
            select * from (
                              select
                                  concat(g.name, '-', g.year, '-', g.number) as agroup,
                                  ld.name_discipline as name,
                                  ld.semester as semester,
                                  ld.course as course ,
                                  sum(ld.contingent) as contingent,
                                  ld.id_pulpit as id_pulpit,
                                  ld.id_teacher
                              from load_distributed as ld
                                       inner join load_group_and_row on load_group_and_row.id_load_distributed = ld.id
                                       inner join `groups` as g on load_group_and_row.id_group = g.id
                              where
                                ld.type = 'p'
                                and ld.id_year_learning=".$practice->year_learning_id."
                                and deleted = 0
                              group by agroup,  name_discipline,  semester,  course,  id_pulpit, id_teacher
                          ) as q

            where
                  -- ( name like 'Учеб%'  or name  like 'Произ%'  or  name  like '%практик%')
                 name       = ".$practice->name." and
                 course     = ".$practice->course." and
                 agroup     = ".$practice->agroup." and
                 semester   = ".$practice->semester."  and
                 id_pulpit  = ".$practice->pulpit->l_pulpit_id."
            ";


            $t_ps = DB::connection($connection)->select($sql);
            foreach ($t_ps as $t_p){

                $teacher = Teacher::where( 'id_teacher',  '=', $t_p->id_teacher)
                                  ->where( 'pulpit_id',  '=', $practice->pulpit->id  )->get();
                if ($teacher->count() > 0) {
                    $teacher = $teacher->first();
                }


            }

        }

    }


}

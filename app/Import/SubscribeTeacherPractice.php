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

        $year_learning = YearLearning::activeYear();

        $years = explode('-', $year_learning->year );

        if ($ed_type ==  1) {
            //$day_sql = "pp.day as day,";
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            //$day_sql = "";
            $id_year_learning = $year_learning->l_id_spo;
        }

        foreach ($practices as $practice) {


            if ($ed_type ==  1) {
                $sql_join_rule = "";
            } else{
                $sql_join_rule = " and block = '". $practice->block ."'";
            }

            $sql ="
            select * from (
                              select
                                  concat(g.name, '-', g.year, '-', g.number) as agroup,
                                  ld.name_discipline as name,
                                  ld.semester as semester,
                                  ld.course as course ,
                                  sum(ld.contingent) as contingent,
                                  ld.id_pulpit as id_pulpit,
                                  ld.id_teacher ,
                                  ld.block as block
                              from load_distributed as ld
                                       inner join load_group_and_row on load_group_and_row.id_load_distributed = ld.id
                                       inner join `groups` as g on load_group_and_row.id_group = g.id
                              where
                                ld.type = 'p'
                                and ld.id_year_learning=".$id_year_learning."
                                and deleted = 0
                              group by agroup,  name_discipline,  semester,  course,  id_pulpit, id_teacher, block
                          ) as q

            where

                 name       = '".$practice->name."' and
                 course     = ".$practice->course." and
                 agroup     = '".$practice->agroup."' and
                 semester   = ".$practice->semester."  and
                 id_pulpit  = ".$practice->pulpit->l_pulpit_id. $sql_join_rule;



            //var_dump($sql);

            $t_ps = DB::connection($connection)->select($sql);
            $t_s_arr = array();

            foreach ($t_ps as $t_p){
                $teacher = Teacher::where( 'l_id',  '=', $t_p->id_teacher)
                                  ->where( 'pulpit_id',  '=', $practice->pulpit->id  )->get();


                if ($teacher->count() > 0) {
                    $teacher = $teacher->first();
                    $t_s_arr[$teacher->id] = array('contingent' => $t_p->contingent);
                }
            }

            $practice->teachers()->sync($t_s_arr, false);

        }

    }


}

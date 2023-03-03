<?php

namespace App\Import;

use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class PracticeImport
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
        // почистить временную таблицу
        PracticeTmp::query()->delete();

        // выкачать практики
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
        }

        // синхронизация
        $this->toRealTableFromTmp();
    }




    private function toRealTableFromTmp()
    {
        // перекопировать
        $sql = "
        insert into practices (name, plan_title, course, semester, date_start, date_end,  depart_name, spec, agroup, contingent, l_id_plan,
                             created_at, updated_at,  education_type_id, year_learning_id, pulpit_id, practice_type_id, pr_state, block)
        select
           pr_tmp.name,
           pr_tmp.plan_title,
           pr_tmp.course,
           pr_tmp.semester,
           pr_tmp.date_start,
           pr_tmp.date_end,
           pr_tmp.depart_name,
           pr_tmp.spec,
           pr_tmp.agroup,
           pr_tmp.contingent,
           pr_tmp.l_id_plan,
           pr_tmp.created_at,
           pr_tmp.updated_at,
           pr_tmp.education_type_id,
           pr_tmp.year_learning_id,
           pr_tmp.pulpit_id,
           pr_tmp.practice_type_id,
           pr_tmp.pr_state,
           pr_tmp.block
        from practices_tmp as pr_tmp left  join practices
           on pr_tmp.name = practices.name
               and pr_tmp.course = practices.course
               and pr_tmp.agroup = practices.agroup
               and pr_tmp.semester = practices.semester
              and pr_tmp.education_type_id = practices.education_type_id
              and pr_tmp.year_learning_id = practices.year_learning_id
              and pr_tmp.pr_state = practices.pr_state
              and pr_tmp.block = practices.block
        where practices.name is null
        ";
     DB::connection('mysql')->insert($sql);

    }

    private function import($connection , $education_type_id  ){ // now practice


        $year_learning = YearLearning::activeYear();

        $years = explode('-', $year_learning->year );

        if ($education_type_id ==  1) {
            //$day_sql = "pp.day as day,";
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            //$day_sql = "";
            $id_year_learning = $year_learning->l_id_spo;
        }
        //var_dump($years);

        //var_dump($year_learning->id_spo);


        $sql2 = "
    select * from (
         select
             concat(g.name, '-', g.year, '-', g.number) as agroup,
             ld.name_discipline as name,
             ld.semester as semester,
             ld.course as course ,
             sum(ld.contingent) as contingent,
             min(ld.id_plan) as l_id_plan,
             pp.name as plan_title,
             ld.id_pulpit as id_pulpit,
             concat(dr.code, ' ', dr.name, ' ', pf.name) as spec,
             d.name as depart_name,
             ld.block as block
         from load_distributed as ld
                  inner join load_group_and_row on load_group_and_row.id_load_distributed = ld.id
                  inner join
                        (`groups` as g join (profile pf join direction dr on pf.id_direction=dr.id) on g.id_profile = pf.id)
                      on load_group_and_row.id_group = g.id
                  inner join (department as d join department_and_pulpit as dp on d.id=dp.id_department  ) on dp.id = g.id_department_and_pulpit

                  left join `plan_title` as pp on g.id_plan =  pp.id
         where
             ld.type = 'p'
           and ld.id_year_learning=".$id_year_learning."
            and deleted = 0

         group by agroup, spec, name_discipline,  semester,  course,  id_pulpit, depart_name, plan_title, block
     ) as q

    where  ( name like 'Учеб%'  or name  like 'Произ%'  or  name  like '%практик%')
    order by  agroup";



        $practices = DB::connection($connection)->select($sql2);
        $pr_arr = [];


        foreach( $practices as $practice){
            $tmp_practice = (array)$practice;
            $tmp_practice['education_type_id']  = $education_type_id; // vo
            $tmp_practice['year_learning_id'] =  $year_learning->id;


            $pulpit = Pulpit::where('year_learning_id',   '=',    $year_learning->id)
                ->where(  'l_pulpit_id',        '=',    $practice->id_pulpit)
                ->where(  'education_type_id',  '=',    $education_type_id)
                ->first();

            unset($tmp_practice['id_pulpit']);

            $tmp_practice['pulpit_id'] =  $pulpit->id;
            $tmp_practice['pr_state'] =  'n';

            PracticeTmp::create($tmp_practice );


        }
        // проставить даты
    }




}

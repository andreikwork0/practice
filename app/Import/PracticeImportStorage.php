<?php

namespace App\Import;

use App\Models\Practice;
use App\Models\PracticeStorage;
use App\Models\Pulpit;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class PracticeImportStorage
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
        PracticeStorage::query()->delete();

        // выкачать практики
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
            // синхронизация
            $this->toRealTableFromStorage($setting['ed_type']);
        }


    }






    private function toRealTableFromStorage($education_type_id)
    {

        if ($education_type_id == 2) {
            $sql_join = " and pr_str.block = practices.block ";
        } else {
            $sql_join = "";
        }
        // перекопировать

        $sql = "
        insert into practices (name, plan_title, course, semester, date_start, date_end,  depart_name, spec, agroup, contingent, l_id_plan,
                             created_at, updated_at,  education_type_id, year_learning_id, pulpit_id, practice_type_id, pr_state, block)
        select
           pr_str.name,
           pr_str.plan_title,
           pr_str.course,
           pr_str.semester,
           pr_str.date_start,
           pr_str.date_end,
           pr_str.depart_name,
           pr_str.spec,
           pr_str.agroup,
           pr_str.contingent,
           pr_str.l_id_plan,
           pr_str.created_at,
           pr_str.updated_at,
           pr_str.education_type_id,
           pr_str.year_learning_id,
           pr_str.pulpit_id,
           pr_str.practice_type_id,
           pr_str.pr_state,
           pr_str.block
        from practices_storage as pr_str left  join practices
           on pr_str.name = practices.name
               and pr_str.course = practices.course
               and pr_str.agroup = practices.agroup
               and pr_str.semester = practices.semester
              and pr_str.education_type_id = practices.education_type_id
              and pr_str.year_learning_id = practices.year_learning_id
              and pr_str.pr_state = practices.pr_state " . $sql_join."
             where practices.name is null and pr_str.pr_state = 'f' and pr_str.education_type_id = " .$education_type_id;
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


        $sql2 = "
        select * from (
                          select CASE
                                     WHEN (pr1.course = g_c.cource_now) THEN ('n')
                                     WHEN (pr1.course = g_c.cource_now + 1 and pr1.semester = 1) THEN ('f')
                                     WHEN (pr1.course > g_c.cource_now) THEN ('f_t')
                                     WHEN (pr1.course < g_c.cource_now) THEN ('p')
                                     END as pr_state,
                                 pr1.*
                          from (
                                   SELECT pp.id                                         as l_id_plan,
                                          pp.name                                       as name,
                                          pt.name                                       as plan_title,
                                          pp.course                                     as course,
                                          pp.semester                                   as semester,
                                          concat(dr.code, ' ', dr.name, ' ', pf.name)   as spec,
                                          concat(gr.name, '-', gr.year, '-', gr.number) as agroup,
                                          gr.contingent                                 as contingent,
                                          pul.id                                        as id_pulpit,
                                          d.name                                        as depart_name,
                                          pp.block                                      as block
                                   FROM plan_practice pp
                                            join ( groups gr join (profile pf join direction dr on pf.id_direction = dr.id)
                                       on gr.id_profile = pf.id) on pp.id_plan = gr.id_plan
                                            join (department as d join department_and_pulpit as dp on d.id = dp.id_department )
                                                 on dp.id = gr.id_department_and_pulpit
                                            join  (pulpit as pul join department_and_pulpit   on pul.id = department_and_pulpit.id_pulpit )
                                                on  department_and_pulpit.id = gr.id_department_and_pulpit
                                            join plan_title pt on pp.id_plan = pt.id
                                   where gr.id_year_learning = ".$id_year_learning."
                                     and (pp.type in ('p', 'l'))
                                     and gr.contingent > 0
                                   order by pp.id_plan
                               ) as pr1
                                   inner join
                               groups_course as g_c on g_c.agroup = pr1.agroup
                      ) as q
        where
            pr_state = 'f'
            or
            pr_state = 'p'";


        $practices = DB::connection($connection)->select($sql2);

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
            //$tmp_practice['pr_state'] =  'n';
            PracticeStorage::create($tmp_practice );
        }
        // проставить даты
    }

}

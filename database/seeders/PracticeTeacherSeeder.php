<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\PracticeTeacher;
use App\Models\YearLearning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PracticeTeacherSeeder extends Seeder
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

        /*
         * 1) Получить практики за активный год
         * по тому уровню образования
         *
         * 2) Сделать запрос по  l_pr_id в нагрузку
         *
         * 3) Записать в бд практики
         *
         */

        $year_learning= settings;

        if ($education_type_id ==  1) {
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            $id_year_learning = $year_learning->l_id_spo;
        }


        $sql = "
            select * from (
                SELECT
               load_distributed.name_discipline as name,
               load_distributed.id_year_learning as id_year_learning,
               qgroup.gname as gname,
               load_distributed.contingent as contingent,
               load_distributed.course as  course,
               load_distributed.semester as semester,
               load_distributed.id_teacher as  id_teacher,
               load_distributed.id_plan as l_id_plan,
               t.firstname as firstname,
               t.lastname as lastname,
               t.surname as surname,
               t.type as type,
               t.post as post
               from
                      load_distributed inner join
                      (select  groups.id, concat(name, '-',year, '-', number) as gname, lgr.id_load_distributed from groups
                        inner join load_group_and_row as lgr on lgr.id_group = groups.id) as qgroup on qgroup.id_load_distributed = load_distributed.id
                      inner join (

                          select
                              lt.id as id,
                              lt.surname as surname,
                              lt.firstname as firstname,
                              lt.lastname as lastname,

                              IFNULL(load_type_teacher.name, '-' ) as type,
                              IFNULL(ltp.name, '-')  as post
                          from
                              load_teacher as lt left   join
                              load_type_teacher on load_type_teacher.id = lt.id_load_type_teacher
                                                 left   join load_teacher_post ltp on lt.id_load_teacher_post = ltp.id


                      ) t on t.id = load_distributed.id_teacher
                ) as q1
                where
                    q1.id_year_learning = ".$id_year_learning;

        $tmp_teachers = DB::connection($connection)->select($sql);

        //$a_tmp_t = array();
        foreach ($tmp_teachers as $key => $tmp_teacher)
        {
            //$tmp_teachers[$key] = (array)$tmp_teacher;
            DB::connection('mysql')->table('practice_teachers_tmp')->insert((array)$tmp_teacher);
        }
        //DB::connection('mysql')->table('practice_teachers_tmp')->insert($tmp_teachers);



        //$practises = Practice::all();

        /*
        foreach ($practises as $practise) {
            $sql = "
            select * from (
                SELECT
               load_distributed.name_discipline as name,
               load_distributed.id_year_learning as id_year_learning,
               qgroup.gname as gname,
               load_distributed.contingent as contingent,
               load_distributed.course as  course,
               load_distributed.semester as semester,
               load_distributed.id_teacher as  id_teacher,
               load_distributed.id_plan as l_id_plan,
               t.firstname as firstname,
               t.lastname as lastname,
               t.surname as surname,
               t.type as type,
               t.post as post
               from
                      load_distributed inner join
                      (select  groups.id, concat(name, '-',year, '-', number) as gname, lgr.id_load_distributed from groups
                        inner join load_group_and_row as lgr on lgr.id_group = groups.id) as qgroup on qgroup.id_load_distributed = load_distributed.id
                      inner join (

                          select
                              lt.id as id,
                              lt.surname as surname,
                              lt.firstname as firstname,
                              lt.lastname as lastname,

                              IFNULL(load_type_teacher.name, '-' ) as type,
                              IFNULL(ltp.name, '-')  as post
                          from
                              load_teacher as lt left   join
                              load_type_teacher on load_type_teacher.id = lt.id_load_type_teacher
                                                 left   join load_teacher_post ltp on lt.id_load_teacher_post = ltp.id


                      ) t on t.id = load_distributed.id_teacher
                ) as q1
                where   q1.name = '".$practise->name."' and  q1.gname ='".$practise->agroup."' and
                        q1.id_year_learning = ".$id_year_learning." and
                        q1.course = :course and  q1.semester = :semester and  q1.l_id_plan = :l_id_plan;";

            $teachers = DB::connection($connection)->select($sql, [
//                "name" => $practise->name,
                //"agroup" => $practise->agroup,
                "course" => $practise->course,
                "semester" => $practise->semester,
                "l_id_plan" => $practise->l_id_plan,
            ]);

            foreach ($teachers as $teacher) {
                PracticeTeacher::create([
                    "fname" => $teacher->firstname,
                    "lname" => $teacher->surname,
                    "mname" => $teacher->lastname,
                    "hours" => $teacher->contingent,
                    "post" => $teacher->post,
                    "practice_id" => $practise->id
                ]);
            }
        }

        */


//fname
//lname
//mname
//post
//hours
//practice_id




//        Practice::where
//
//        $sql = "SELECT *  FROM pulpit as p WHERE  p.id_year_learning  = :year";
//        $year_learning = YearLearning::activeYear();
//
//        $id_year_load = 0;
//        if ($education_type_id == 1){
//            $id_year_load = $year_learning->l_id_vo;
//        } else {
//            $id_year_load = $year_learning->l_id_spo;
//        }
//
//
//        $pulpits = DB::connection($connection)->select($sql, ["year" => $id_year_load ]);
//        foreach( $pulpits as $pulpit){
//            $tmp_pulpit = array(
//                "name"                  =>  $pulpit->name,
//                "education_type_id"     =>  $education_type_id,
//                "year_learning_id"      =>  $year_learning->id,
//                "l_pulpit_id"           =>  $pulpit->id,
//                "code"                  =>  $pulpit->code
//            );
//            PracticeTeacher::create($tmp_pulpit );
//        }

    }
}

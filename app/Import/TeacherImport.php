<?php

namespace App\Import;


use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;

use App\Models\Teacher;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class TeacherImport
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

        // выкачать группы
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
        }
    }





    private function import($connection , $education_type_id  ){
        $year_learning = YearLearning::activeYear();
        if ($education_type_id ==  1) {
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            $id_year_learning = $year_learning->l_id_spo;
        }

        $sql2 = "
        select
            lt.id as id,
            lt.surname as surname,
            lt.firstname as firstname,
            lt.lastname as lastname,
            id_pulpit,
            IFNULL(load_type_teacher.name, '-' ) as type,
            IFNULL(ltp.name, '-')  as post
        from
            load_teacher as lt left   join
            load_type_teacher on load_type_teacher.id = lt.id_load_type_teacher
                               left   join load_teacher_post ltp on lt.id_load_teacher_post = ltp.id
            where id_year_learning=" .$id_year_learning;

        $teachers = DB::connection($connection)->select($sql2);
        foreach( $teachers as $teacher){
            $array = array(
                'surname' =>  $teacher->surname,
                'firstname' =>  $teacher->firstname,
                'lastname'  => $teacher->lastname,

                'l_id' =>  $teacher->id,
                'l_id_pulpit' =>  $teacher->id_pulpit,

                'type' => $teacher->type,
                'post' => $teacher->post
            );

            $pulpit =
                    Pulpit::where(
                        'l_pulpit_id', '=', $teacher->id_pulpit
                    )->where(
                        'education_type_id', '=', $education_type_id
                    )->where(
                        'year_learning_id', '=', $year_learning->id
                    )->get();



            if (!$pulpit->isEmpty()){
                $pulpit = $pulpit->first();
            } else {
                $pulpit = null;
            }
            if ($pulpit) {

                $array['pulpit_id'] = $pulpit->id;

                Teacher::updateOrCreate(
                    ['l_id' => $teacher->id, 'pulpit_id' => $pulpit->id], $array
                );
            }

            else {
//                var_dump($teacher->id_pulpit);
//                var_dump($education_type_id);
//                var_dump($teacher->id);
            }



        }

    }


}

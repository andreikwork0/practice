<?php

namespace App\Import;

use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;
use App\Models\StudentTmp;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class StudentImport
{
    protected $settings;
    public function __construct($settings = [])
    {
        if (empty($settings)) {
            $settings = array(
                ['connection' => 'student_sqlsrv',
                    'ed_type' =>    1 ],
                ['connection' => 'student_spo_sqlsrv',
                    'ed_type' =>    2 ],
            );
        }
        $this->settings = $settings;
    }

    public  function run()
    {
        // почистить временную таблицу
        StudentTmp::query()->delete();

        // выкачать студентов
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
        // для новых инсерт
        $sql = "
        insert into
            students (pers_kod, kod_agr, family, name1, name2, name_ar,  education_type_id, kurs, is_active, kod_osn, name_osn,
                             created_at, updated_at )
        select
           st_tmp.pers_kod,
           st_tmp.kod_agr,
           st_tmp.family,
           st_tmp.name1,
           st_tmp.name2,
           st_tmp.name_ar,
           st_tmp.education_type_id,
           st_tmp.kurs,
           st_tmp.is_active,
           st_tmp.kod_osn,
           st_tmp.name_osn,
           st_tmp.created_at,
           st_tmp.updated_at
        from students_tmp as st_tmp left  join students on
               st_tmp.education_type_id = students.education_type_id
               and st_tmp.pers_kod = students.pers_kod
        where students.name1 is null
        ";


     DB::connection('mysql')->insert($sql);

    // для старых апдейт

    $sql2 =
        "
        UPDATE students
        INNER JOIN   students_tmp as st_tmp  ON students.pers_kod = st_tmp.pers_kod and  st_tmp.education_type_id = students.education_type_id
        SET
           students.kod_agr =  st_tmp.kod_agr,
           students.family      = st_tmp.family,
           students.name1       = st_tmp.name1,
           students.name2       = st_tmp.name2,
           students.name_ar     = st_tmp.name_ar,
           students.kurs        = st_tmp.kurs,
           students.is_active   = st_tmp.is_active,
           students.kod_osn     = st_tmp.kod_osn,
           students.name_osn    = st_tmp.name_osn,
           students.updated_at  = st_tmp.updated_at
        ";


        DB::connection('mysql')->update($sql2);
    }

    private function import($connection , $education_type_id  ){ // now practice



        $sql2 = "select * from [v_StudInGroupAll]";



        $students = DB::connection($connection)->select($sql2);


        foreach( $students as $student){


            $array = array(

            'pers_kod' =>  $student->Pers_Kod,
            'kod_agr'  => $student->Kod_aGr,

            'family' =>  $student->Family,
            'name1' => $student->Name1,
            'name2' => $student->Name2 ?? NULL,
            'name_ar' => $student->NameGr,

            'education_type_id' => $education_type_id,

            'kurs' =>  $student->Kurs,
            'is_active' => $student->isActive,

            'kod_osn' => $student->Kod_OsnO,
            'name_osn' => $student->Name_OsnO

            );

            StudentTmp::create($array );

        }

    }


}

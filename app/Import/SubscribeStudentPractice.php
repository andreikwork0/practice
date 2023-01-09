<?php

namespace App\Import;

use App\Models\Practice;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class SubscribeStudentPractice
{


    public  function run()
    {

        $practices = Practice::query()->filter(['pr_state' => 'n'])->get(); // 'n'  и  с текущим годом
        foreach ($practices as $practice) {
            // получить студентов с этой практики
            $pr_students = $practice->pr_students()->select('student_id')->get();
            $ar_pr_students = array();
            foreach ($pr_students as $pr_student) {
                $ar_pr_students[] = $pr_student->student_id;
            }
            // получить студентов с группы
            $gr_students =  $practice->students_gr()->select('id')->get();
            $ar_students_gr = array();
            foreach ($gr_students as $gr_student) {
                $ar_students_gr[] = $gr_student->id;
            }
            $ar_diff = array();
            $ar_diff = array_diff($ar_students_gr, $ar_pr_students);
            if ($ar_diff) {
                $n_arr = array();
                foreach ($ar_diff as $s) {
                    $n_arr[] =  array('student_id' => $s);
                }
                $practice->pr_students()->createMany($n_arr);
            }
            $this->updateContingent($practice);
        }

    }

    public function updateContingent(&$practice){

        $st = $practice->pr_students;
        if ($st) {
            $c = $st->count();
        } else
        {
            $c = 0;
        }
        $practice->contingent = $c;
        $practice->save();
    }






}

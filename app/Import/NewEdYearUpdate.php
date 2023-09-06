<?php

namespace App\Import;

use App\Models\DGroup;
use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;
use App\Models\StudentTmp;
use App\Models\Teacher;
use App\Models\User;
use App\Models\YearLearning;
use Database\Seeders\PulpitSeeder;
use Database\Seeders\YearLearningSeeder;
use Illuminate\Support\Facades\DB;

class NewEdYearUpdate
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

        try {
            DB::beginTransaction();

            //  поставить не активный год
            YearLearning::query()->update(['active'=> 0]);

            // скачали год
            $YearLearningSeeder = new   YearLearningSeeder();
            $YearLearningSeeder->run();

            // скачали кафедры
            $PulpitSeeder = new PulpitSeeder();
            $PulpitSeeder->run();


            // поменять статусы
            Practice::where('pr_state', '=', 'n')->update(['pr_state' => 'p']);
            Practice::where('pr_state', '=', 'f')->update(['pr_state' => 'n']);


            //  обновить год
            $year_learning = YearLearning::activeYear();
            Practice::query()->update(['year_learning_id' => $year_learning->id]);

            // обновить id_кафедр для практик
            $practices = Practice::all();
            foreach ($practices as $practice)
            {
                $practice->pulpit_id =  $practice->pulpit->getByCodeParent();
                $practice->save();
            }

            // обновить id_кафедр для пользователей
            $users = User::all();
            foreach ($users as $user)
            {
                if ($user->pulpit_id) {
                    $user->pulpit_id =  $user->pulpit->getByCodeParent();
                    $user->save();
                }
            }

            // скачать преподов
            $TeacherImport = new TeacherImport();
            $TeacherImport->run();

            $practices = Practice::query()->filter(['pr_state' => 'n'])->get(); // 'n'  и  с текущим годом

            foreach ($practices as $practice)
            {
                $pr_students = $practice->pr_students;
                foreach ($pr_students as $pr_student) {
                    $teacher = $pr_student->teacher;
                    if ($teacher) {
                        $upTeacher = $teacher->upTeacher();
                        if ($upTeacher) {
                            $pr_student->teacher_id = $upTeacher->id;
                        } else {
                            $pr_student->teacher_id = NULL;
                        }
                        $pr_student->save();
                    }
                }
            }

            // скачать орг структру
            $OrgStructureMgtuImport = new OrgStructureMgtuImport();
            $OrgStructureMgtuImport->run();


            $DGroupImport = new DGroupImport();
            $DGroupImport->run();

            $PracticeImport = new PracticeImport();
            $PracticeImport->run();

            $PracticeImportStorage = new PracticeImportStorage();
            $PracticeImportStorage->run();


            $StudentImport = new StudentImport();
            $StudentImport->run();

            $SubscribeStudentPractice = new SubscribeStudentPractice();
            $SubscribeStudentPractice->run();


            $SubscribeTeacherPractice = new SubscribeTeacherPractice();
            $SubscribeTeacherPractice->run();



            DB::commit();

        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            DB::rollBack();
        }


    }






}

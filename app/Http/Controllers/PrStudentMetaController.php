<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\Practice;
use App\Models\PrStudent;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class PrStudentMetaController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {

        $practice = Practice::find($id);
        $students = $practice->pr_students()->get();



        $students =  $students->sortBy(function ($student) {
            return $student->student->family;
        });

        $s = Setting::key_val();

        foreach ($students as $student) {
            if ($student->dp) {

                if ($student->dp->company->id == $s['univer_id'] )
                {
                    $student->dir_flag = 0;
                }
                else {
                    $student->dir_flag = 1;
                }
                $student->company_name = $student->dp->company->name;

                if ($student->dp->org_structure){
                    $student->company_name.= '('.$student->dp->org_structure->name_short.')';
                }

            } else {
                $student->company_name = 'не определено';


                $student->dir_flag = 1;
            }
        }

        $teachers = $practice->teachers;

        if (  $teachers->count() <= 0 )
        {
            $teachers = Teacher::where('pulpit_id', '=', $practice->pulpit_id)->get();
        }

        $ar = [];
        foreach ($teachers as $teacher)
        {
            $tm_object = new \StdClass();
            $tm_object->id = $teacher->id;
            $tm_object->name = ($teacher->surname ?? '') . ' ' . ($teacher->firstname ?? '') . ' '. ($teacher->lastname ?? '');
            $ar[]= $tm_object;
        }


        return view('pr_student_meta.edit', [ 'practice' => $practice,
                                                    'teachers' => $ar,
                                                    'students' => $students ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $practice = Practice::findOrFail($id);

        //return dd($request->input('pr_students'));
        foreach ($request->input('pr_students') as $pr_stud)
        {
            $id = $pr_stud['id'];
            unset($pr_stud['id']);
            PrStudent::where(  'id', '=', $id  )->update($pr_stud);
        }

        return  redirect()->route('pr_student_meta.edit', $practice->id )->with('success', 'Данные успешно обновлены');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\Practice;
use App\Models\PrStudent;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class PrStudentToolController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {

        $practice = Practice::findOrFail($id);
        $students = $practice->pr_students()->get();

        $students =  $students->sortBy(function ($student) {
            return $student->student->family;
        });

        foreach ($students as $student) {
            if ($student->dp) {
                $student->company_name = $student->dp->company->name;

                if ($student->dp->org_structure){
                    $student->company_name.= '('.$student->dp->org_structure->name_short.')';
                }
            } else {
                $student->company_name = 'не определено';
            }

            /*
          * tool ids
          */
            $student->tool_arr = [];
            $tmp_arr  = array();
            if ( $student->tools) {

                foreach ($student->tools as $t) {
                    $tmp_arr []= $t->id;
                }
            }
            $student->tool_arr = $tmp_arr;
        }

        /*
         * additional logic for  filter tools
         */

        return view('pr_student_tool.edit', [ 'practice' => $practice,
                                                    'tools' => Tool::query()->orderBy('name', 'asc')->get(),
                                                    'students' => $students ] );
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
            //dd($pr_stud['tool_ar']);

            $pr_s = PrStudent::findOrFail($id);
            $pr_s->tools()->sync($pr_stud['tool_ar'] ?? []);
        }

        return  redirect()->route('pr_student_tool.edit', $practice->id )->with('success', 'Данные успешно обновлены');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\Practice;
use App\Models\PrStudent;
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

        foreach ($students as $student) {
            if ($student->dp) {
                $student->company_name = $student->dp->company->name;

                if ($student->dp->org_structure){
                    $student->company_name.= '('.$student->dp->org_structure->name_short.')';
                }

            } else {
                $student->company_name = 'не определено';
            }
        }

        return view('pr_student_meta.edit', [ 'practice' => $practice,
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

<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\ListTool;
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

        $tools = Tool::query()->orderBy('name', 'asc')->get();
        foreach ($students as $student) {
            if ($student->dp) {
                $student->company_name = $student->dp->company->name;

                $org_str_id = false;

                if ($student->dp->org_structure){
                    $student->company_name.= '('.$student->dp->org_structure->name_short.')';
                    $org_str_id =  $student->dp->org_structure->id;
                }

                $query_list_tool = ListTool::where('company_id', $student->dp->company->id); //->where('org_structure_id')
                if ($org_str_id) {
                    $query_list_tool->where('org_structure_id', $org_str_id);
                }

                $list_tools = $query_list_tool->get();

                if ($list_tools->count() > 0) {
                    $tool_collection = collect();
                    foreach ($list_tools as $lt) {
                        $tool_collection->add($lt->tool);
                    }
                }
                else {
                    $tool_collection = $tools;
                }


            } else {
                $student->company_name = 'не определено';
                $tool_collection = $tools;
            }

            $student->tool_collection = $tool_collection;

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

            /*
            * tool ids
            */


        }

        /*
         * additional logic for  filter tools
         */

        return view('pr_student_tool.edit', [ 'practice' => $practice,
                                                    //'tools' => $tool_collection,//Tool::query()->orderBy('name', 'asc')->get(),
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

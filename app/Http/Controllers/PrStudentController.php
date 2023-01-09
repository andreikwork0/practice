<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class PrStudentController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {



        $dp = DistributionPractice::find($id);
        $c_s_dp = $dp->pr_students;
        $c_s_dp = $c_s_dp->count();


        $practice = $dp->practice;
        $ed_ss = $practice->pr_students()->orderBy('distribution_practice_id')->get();

        $col_edit = collect(array());
        $col_stat = collect(array());
        foreach ($ed_ss as $ed_s) {
            if  ( ($ed_s->distribution_practice_id == $dp->id ) || (is_null($ed_s->distribution_practice_id)) )
                $col_edit->push($ed_s);
            else $col_stat->push($ed_s);
        }

//        print_r($col_edit->count());
//
//        print_r("_______________________________");
//        print_r($col_stat->count());


        return view('pr_student.edit', [   'col_edit_ss'=> $col_edit,
                                                'col_stat_ss' => $col_stat,
                                                'dp' => $dp,
                                                 'practice' => $practice,
                                                'c_s_dp' => $c_s_dp
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $dp = DistributionPractice::findOrFail($id);
        $num_fact = $dp->num_fact;

        if ($request->input('pr_students_id')) {
            $c = count($request->input('pr_students_id'));
        } else {
            $c = 0;
        }



        if ( $c > $num_fact ) {
            $er_text = array('errors' => "превышен лимит по количеству мест $num_fact . выбрано " . $c);
            //return redirect()->route('pr_student.edit', $dp->id)->withErrors($er_text)->withInput();
            return back()->withInput($request->all())->withErrors($er_text);
        }



        $select_stud = $request->input('pr_students_id');
        $sel_arr = array();
        if ($select_stud) {
            foreach ($select_stud as $key => $stud) {
                if ($stud == 'on') $sel_arr[] = $key;
            }
        }

        $all_sts = $dp->practice->pr_students;

        foreach ($all_sts as $st) {
            if (in_array($st->id, $sel_arr)) {
                $st->distribution_practice_id = $dp->id;
            }
            elseif($st->distribution_practice_id ==  $dp->id ) {
                $st->distribution_practice_id = NULL;
            }
            $st->save();
        }

        return  redirect()->route('practices.show',$dp->practice->id )->with('success', 'Данные успешно обновлены');
    }


    public function customValidation()
    {
        //
    }
}

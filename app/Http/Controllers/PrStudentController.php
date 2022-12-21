<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PrStudentController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
                                                'dp' => $dp, 'practice' => $practice,
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
        $dp = DistributionPractice::find($id);
        $num_fact = $dp->num_fact;
    }


    public function customValidation()
    {
        //
    }
}

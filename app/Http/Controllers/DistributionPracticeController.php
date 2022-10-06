<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\Practice;
use App\Models\PracticeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DistributionPracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,  $pr_id)
    {



        $practice = Practice::findOrFail($pr_id);
        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }
//
        $request->validate([
            'company_id'        =>  'required',
            'num_plan'          =>  'required|int'
        ]);

        $dp = DistributionPractice::create(array_merge($request->all(), array('user_id' => $user->id, 'practice_id' => $practice->id  )));

        return redirect()->route('practices.show', ['practice' =>  $practice ])->with('success', "Практика обновлена");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dp = DistributionPractice::find($id);


        $practice = $dp->practice;

        $dp->delete();
        return redirect()->route('practices.show', ['practice' =>  $practice ])->with('success', "Распределение удалено");

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\EducationType;
use App\Models\OrgStructure;
use App\Models\Practice;
use App\Models\PracticeForm;
use App\Models\PracticeType;
use App\Models\Pulpit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $user = Auth::user();

        $filters = array();
        if ($user->isRole('kaf')) {

            $filters = ['pulpit' => $user->pulpit_id];
        }

        $filters = array_merge(request(['semester', 'course', 'pulpit', 'ed_type' ,'pr_state']), $filters);


        $course_arr = array();
        for ($i  = 1; $i <9 ; $i++){
            $course  = new \stdClass();
            $course->id     =   $i;
            $course->name   =   $i . ' курс';
            $course_arr[] = $course;
        }

        $semester_arr = array();
        for ($i  = 1; $i <3 ; $i++){
            $semester  = new \stdClass();
            $semester->id     =   $i;
            $semester->name   =   $i . ' семестр';
            $semester_arr[] = $semester;
        }


        $p_filters = array();
        $ed_type = request('ed_type');
        if ($ed_type) {
            $p_filters = array('ed_type' => $ed_type );
            $pulpits = Pulpit::filter($p_filters)->get();
        } else {
            $pulpits =  array();
        }

        $pr_states = array();

        $pr_state_s  = new \stdClass();
        $pr_state_s->id     =   'p';
        $pr_state_s->name   =   'Прошлые';
        $pr_states[]= $pr_state_s;

        $pr_state_s  = new \stdClass();
        $pr_state_s->id     =   'n';
        $pr_state_s->name   =   'Текущие';
        $pr_states[]= $pr_state_s;

        $pr_state_s  = new \stdClass();
        $pr_state_s->id     =   'f';
        $pr_state_s->name   =   'Будущие';
        $pr_states[]= $pr_state_s;




        return view('practice.index', [
            'practices' =>  Practice::filter($filters)->paginate(10)->withQueryString(),
            'courses'   => $course_arr,
            'semesters' => $semester_arr,
            'ed_types'  => EducationType::all(),
            'pulpits'   => $pulpits,
            'pr_states' => $pr_states
        ]);

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $practice = Practice::findOrFail($id);
        $companies = Company::all();
        // gate
        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }

        $ors = new OrgStructure();


        return view('practice.show', ['practice' =>  $practice, 'companies' => $companies, 'orgs' =>  $ors->getTree(282) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $practice = Practice::findOrFail($id);
        // gate
        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }

        return view('practice.edit', ['practice' =>  $practice, 'types' => PracticeType::all(), 'forms'     => PracticeForm::all() ]);
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

        $practice = Practice::findOrFail($id);
        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }

        //$this->valideRequest($request);
        $request->validate([
            'date_start'        =>  'required|date',
            'date_end'          =>  'required|date|after_or_equal:date_start',
            'practice_type_id'  => 'required',
            'practice_form_id'  => 'required',

        ]);

        $practice->update($request->all());
        return redirect()->route('practices.edit', ['practice' =>  $practice, 'types' => PracticeType::all() ])->with('success', "Практика обновлена");
    }


}

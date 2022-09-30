<?php

namespace App\Http\Controllers;

use App\Models\EducationType;
use App\Models\Practice;
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

        $filters = array_merge(request(['semester', 'course', 'pulpit', 'ed_type']), $filters);


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



        return view('practice.index', [
            'practices' =>  Practice::filter($filters)->paginate(10)->withQueryString(),
            'courses'   => $course_arr,
            'semesters' => $semester_arr,
            'ed_types'  => EducationType::all(),
            'pulpits'   => $pulpits,
        ]);

        //  год ( default - yearlining ) -- drop down ??
        //  уровень образования ( default ВО ) - не зависит от года -- drop down ?? с линкой

        // динамическая
        //  кафедра ( default null ) - зависит от года и от уровня образования
        // она должна перерисовываться каждый раз когда меняется год или спо / во

        // можно выставить по умолчанию ВО и тек год

        // если чел относиться к какаой-то специфичной кафедре надо ему сразу эти настройки выставить

        // курс ( default null )    -- drop down ?? с линкой
        // семестр ( default null ) -- drop down ?? с линкой

        /*
         *  1 ) php
         *
         *  надо собирать url
         *  добавлять к нему аргументы
         *
         *  создать элемент dropdown

         *
         *
         *  2) vue js
         *  json filter
         *  но это должно стыковаться с пагинацией ???
         *
         *
         * 3) php form filter
         *
         *
         */


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
        $practice = Practice::findOrFail($id);
        // gate
        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }

        return view('practice.edit', ['practice' =>  $practice, 'types' => PracticeType::all() ]);
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
            'practice_type_id'  => 'required'
        ]);

        $practice->update($request->all());
        return redirect()->route('practices.edit', ['practice' =>  $practice, 'types' => PracticeType::all() ])->with('success', "Практика обновлена");
    }


}

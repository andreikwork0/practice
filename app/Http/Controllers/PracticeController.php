<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('company.index', ['companies' =>
            Practice::orderby('name')
                ->filter(request(['search'] ))
                ->paginate(10)
                ->withQueryString()]);

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}

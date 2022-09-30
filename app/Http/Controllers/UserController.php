<?php

namespace App\Http\Controllers;

use App\Models\EducationType;
use App\Models\Pulpit;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('user.index', ['users' =>
            User::filter(request(['search'] ))->paginate(10)->withQueryString()
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);


        $p_filters = array();
        $ed_type = $user->education_type;
        if ($ed_type) {
            $p_filters = array('ed_type' => $ed_type->id );
            $pulpits = Pulpit::filter($p_filters)->get();
        } else {
            $pulpits =  array();
        }




        $args = array(
            'user'      => User::find($id),
            'roles'     => Role::all(),
            'ed_types'  => EducationType::all(),
            'pulpits'   => $pulpits,
        );

        return view('user.edit', $args);
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

        $user = User::findOrFail($id);
//        dd($request->all());
        $user->update($request->all());
        return redirect()->route('users.edit', $user)->with('success', "Пользователь обновлен");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $user->delete();
        return redirect()->route('users.index')->with('success', "Пользователь удален $name");
    }

}

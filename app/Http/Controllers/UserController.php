<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


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
            User::paginate(10)
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

//        $roles = $user->roles;

        $cur_role_id =  false;
//
//        if (count($roles)>0) {
//            $cur_role_id = $roles[0]->id;
//        }


        $args = array(
            'user'      => User::find($id),
            'roles'     => Role::all(),
            'cur_role' => $cur_role_id
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
        $user->update($request->except('role_id'));
        //dd($request->input('role_id'));
        if ($request->input('role_id')) {
            $role = Role::findById($request->input('role_id'));
            $user->syncRoles($role);
        } else {
            $user->syncRoles();
        }

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

<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PracticeTeacherController extends Controller
{
    //

    public function show(Request $request, $id)
    {
        $practice = Practice::findOrFail($id);


        $user = Auth::user();
        if ($user->isRole('kaf')) {
            if (! Gate::allows('edit-practice', $practice)) {
                abort(403);
            }
        }

        $teachers = $practice->teachers;


        return view('pr_teacher.show', [
           'practice' =>  $practice,
           'teachers' =>  $teachers,
        ]);

    }
}

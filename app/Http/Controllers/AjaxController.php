<?php

namespace App\Http\Controllers;

use App\Models\Pulpit;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getPulptitByEdType($id){
        $p_filters = array('ed_type' => $id );
        $pulpits = Pulpit::filter($p_filters)->get();
        return  response()->json([
            'data' => $pulpits->toJson()
        ]);
    }
}

<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Convention;
use Illuminate\Http\Request;

class ConventionEduController extends ConventionController implements ConventionInterface
{

    public function edit($id)
    {

        $conv = Convention::findOrFail($id);
        return view('convention.types.edu', ['convention' => $conv ]);
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement update() method.
    }

    public function generate($id)
    {
        // TODO: Implement generate() method.
    }
}

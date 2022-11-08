<?php

namespace App\Http\Controllers\Convention;

use App\Models\Convention;
use Illuminate\Http\Request;

class ConventionPremController extends ConventionController implements ConventionInterface
{


    public function edit($id)
    {
        $conv = Convention::findOrFail($id);
        return view('convention.types.prem', ['convention' => $conv ]);
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

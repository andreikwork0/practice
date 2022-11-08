<?php

namespace App\Http\Controllers\Convention;

use App\Models\Convention;
use Illuminate\Http\Request;

class ConventionOthController extends ConventionController implements ConventionInterface
{

    public function edit($id)
    {
        $conv = Convention::findOrFail($id);
        return view('convention.types.oth', ['convention' => $conv ]);
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

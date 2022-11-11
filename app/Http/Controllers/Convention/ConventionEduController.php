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
        $company = $conv->company;

        // надо получить все c компаниией
        $dist_pr_null = $company->dist_pr()->filter(['arg_null'=> ''])->get() ?? [];

        // надо получить все дитсрибутив связанные с этим соглашением
        $dist_pr_conv = $conv->dist_pr ?? [];


        return view('convention.types.edu',
            ['convention' => $conv,   'dist_pr_null' => $dist_pr_null ]
        );
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

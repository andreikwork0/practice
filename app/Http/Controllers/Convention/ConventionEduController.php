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
        $dist_prs_new      = $company->dist_pr_new;

        // надо получить все дитсрибутив связанные с этим соглашением
        $dist_prs = $conv->dist_pr;



        return view('convention.types.edu',
            ['convention' => $conv,   'dist_prs_new' => $dist_prs_new , 'dist_prs' => $dist_prs ]
        );
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement update() method.

        // пройтись по всем
        // по флажку_ update id

        // обновить поля num_fact
        // обновить поля plan_fact
    }

    public function generate($id)
    {
        // TODO: Implement generate() method.
    }
}

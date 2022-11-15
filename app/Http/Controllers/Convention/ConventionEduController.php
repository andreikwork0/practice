<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Convention;
use App\Models\DistributionPractice;
use Illuminate\Http\Request;

class ConventionEduController extends ConventionController implements ConventionInterface
{

    public function edit($id)
    {


        $conv = Convention::findOrFail($id);
        $company = $conv->company;

        // надо получить все дитсрибутив связанные с этим соглашением
        $dist_prs = $conv->dist_pr;

        // надо получить все c компаниией
        $dist_prs_new      = $company->dist_pr_new;


        return view('convention.types.edu',
            ['convention' => $conv,   'dist_prs_new' => $dist_prs_new , 'dist_prs' => $dist_prs ]
        );
    }

    public function update(Request $request, $id)
    {
        $dprs = $request->input('dp');
        foreach ($dprs as $key => $dpr) {
            $distPractice = DistributionPractice::findOrFail($key);

            $distPractice->num_fact = $dpr["num_fact"];

            if (!empty($dpr["convention"]) == 'on') {
                $distPractice->convention_id = $id;
            } else {
                $distPractice->convention_id = NULL;
            }
            $distPractice->save();
        }

        return redirect()->route('conventions.edit',$id)->with('success', 'Изменения успешные применены');
    }

    public function generate($id)
    {
        // TODO: Implement generate() method.
    }
}

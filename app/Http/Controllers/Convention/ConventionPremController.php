<?php

namespace App\Http\Controllers\Convention;

use App\Models\Convention;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class ConventionPremController extends ConventionController implements ConventionInterface
{


    public function edit($id)
    {
        $conv = Convention::findOrFail($id);

        // все помещения это организации
        $premises = $conv->company->premises;

        // все помещения которые в данное доп соглашение
        $conv_prems = $conv->premises;

        $id_arr_convprem = array();
        foreach ($conv_prems as $conv_prem) {
            $id_arr_convprem[] = $conv_prem->id;
        }

        return view('convention.types.prem', ['convention' => $conv, 'premises' => $premises, 'id_arr_convprem'=> $id_arr_convprem ]);
    }

    public function update(Request $request, $id)
    {
        $conv = Convention::findOrFail($id);

        $pms_arr = array();
        $pms = $request->input('pm');

        foreach ($pms as $key => $value)
        {
            $pms_arr[] = $key;
        }

        $conv->premises()->sync($pms_arr);

        return redirect()->route('conventions.edit', $conv->id)->with('success', 'Данные о помещениях обновлены');

    }

    public function generate($id)
    {
        $conv =  Convention::findOrFail($id);

        $temp_name = $conv->type->template;
        $path = Storage::disk('agreements')->path("/templates/$temp_name");

        $docs = new  TemplateProcessor($path);


        $conv_prems = $conv->premises;


        $i = 1;
        $arr = array();
        foreach ($conv_prems as $conv_prem)
        {
            $arr_single = [];
            $arr_single['n_i'] = $i;
            $arr_single['prem'] = $conv_prem->name;
            $arr[]= $arr_single;
            $i++;
        }

        $docs->cloneRowAndSetValues('prem',$arr );

//

        $name_dpagr =  $this->docs_set_default($docs, $conv);

        header('Content-Disposition: attachment;filename='.$name_dpagr);
        header('Cache-Control: max-age=0');
        $docs->saveAs('php://output');
    }
}

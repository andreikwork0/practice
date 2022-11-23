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
//
        $ag_num = $conv->agreement->num_agreement ??  '__';
        $docs->setValue('ag_num',$ag_num );
//
        $ag_date = $conv->agreement->date_agreement ? date('d.m.Y', strtotime($conv->agreement->date_agreement)) : '__.__.__';
        $docs->setValue('ag_date', $ag_date);
//
        $docs->setValue('dp_num',$conv->number );


        $company = $conv->company;
        // фио short name
        $mng_name = $company->mng_name ?? false;
        $mng_patronymic = $company->mng_patronymic ?? false;
        $com_mng_fio_short = ($mng_name ? mb_substr($mng_name, 0, 1, "UTF-8") .'. ' : '') .  ($mng_patronymic ? mb_substr($mng_patronymic, 0, 1, "UTF-8") .'. ' : '') . ' '. ($company->mng_surname ?? '');
        $docs->setValue('com_mng_fio_short',  $com_mng_fio_short);
        $docs->setValue('com_mng_job',  $company->mng_job ?? '___');

        $s = Setting::key_val();
        $docs->setValue('mng_job', $s['mng_job'] ?? 'XX-XX-XX');

        // фио short name
        $mng_name = $s['mng_fname'] ?? false;
        $mng_patronymic = $s['mng_mname'] ?? false;
        $mng_fio_short = ($mng_name ? mb_substr($mng_name, 0, 1, "UTF-8") .'. ' : '') .  ($mng_patronymic ? mb_substr($mng_patronymic, 0, 1, "UTF-8") .'. ' : '') . ' '. ($s['mng_lname'] ?? '');
        $docs->setValue('mng_fio_short',  $mng_fio_short);



        $name_dpagr = "Доп соглашение № $conv->number к договору № $ag_num .docx";
        header('Content-Disposition: attachment;filename='.$name_dpagr);
        header('Cache-Control: max-age=0');
        $docs->saveAs('php://output');
    }
}

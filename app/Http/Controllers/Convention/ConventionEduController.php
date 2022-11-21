<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Convention;
use App\Models\DistributionPractice;
use App\Models\Practice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

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

    private function dprToDoc($dpr)
    {

        $arr_single = [];
        $arr_single['agroup'] = $dpr->practice->agroup . ' ' . $dpr->practice->depart_name;
        $arr_single['semester'] = $dpr->practice->semester;
        $arr_single['date_start'] = $dpr->practice->date_start ?? '__';
        $arr_single['date_end'] = $dpr->practice->date_end ?? '__';
        $arr_single['spec'] = $dpr->practice->spec ?? '__';
        $arr_single['name'] = $dpr->practice->name ?? '__';
        $arr_single['count'] = $dpr->num_fact ?? $dpr->num_plan;

        return $arr_single;

    }

    public function generate($id)
    {
        // TODO: Implement generate() method.

        $conv =  Convention::findOrFail($id);

        $temp_name = $conv->type->template;
        $path = Storage::disk('agreements')->path("/templates/$temp_name");

        $docs = new  TemplateProcessor($path);



        $dprs = DistributionPractice::join('practices as p', 'p.id','=','distribution_practices.practice_id')
            ->orderBy('p.depart_name')
            ->select('distribution_practices.*') // avoid fetching anything from joined table
            ->with('practice')
            ->where('convention_id', '=', $id)->get();  // if you need managers data anyway



//        $dp_gd = [];
//
//        $g_sum = 0;

//        foreach ($dprs as $dpr)
//        {
//            $dp_gd[$dpr->practice->depart_name]['dp_n'] = $dpr->practice->depart_name;
//            $dp_gd[$dpr->practice->depart_name]['items'][] = $this->dprToDoc($dpr);
//            $dp_gd[$dpr->practice->depart_name]['total'] =  ($dp_gd[$dpr->practice->depart_name]['total'] ?? 0) + ($dpr->num_fact ?? $dpr->num_plan);
//            $g_sum += ($dpr->num_fact ?? $dpr->num_plan);
//        }
//
//        $dp_gd_n = [];
//        foreach($dp_gd as $value){
//            $dp_gd_n[] = $value;
//        }

        //dd($dp_gd_n);

             //$dprs = $dprs->sortBy('depart_name'); // не работает починить

        // количество по институтам
        $sum_all = 0;
        $arr = [];
        foreach ($dprs as $dpr)
        {

            $arr_single = [];
            $arr_single['agroup'] = $dpr->practice->agroup . ' ';  //. $dpr->practice->depart_name;
            $arr_single['semester'] = $dpr->practice->semester;
            $arr_single['date_start'] = $dpr->practice->date_start ?  date('d.m.Y', strtotime($dpr->practice->date_start)) : '__';
            $arr_single['date_end'] = $dpr->practice->date_end ? date('d.m.Y', strtotime($dpr->practice->date_end)) : '__';
            $arr_single['spec'] = $dpr->practice->spec ?? '__';
            $arr_single['name'] = $dpr->practice->name ?? '__';
            $arr_single['count'] = $dpr->num_fact ?? $dpr->num_plan;

            $sum_all+=$arr_single['count'];

            $arr[]= $arr_single;
        }

        $docs->cloneRowAndSetValues('agroup',$arr );

        $docs->setValue('count_all', $sum_all);
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

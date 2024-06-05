<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\PrStudent;
use App\Models\Setting;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DirectionController extends Controller
{



    public function print_all($id)
    {
        $practice = Practice::findOrFail($id);
        $pr_students = $practice->pr_students;
        $s = Setting::key_val();

        foreach ($pr_students as $key => $pr_student)
        {

            if ($pr_student->dp) {

                if ($pr_student->dp->company->id == $s['univer_id'] )
                {
                    $org1 = $pr_student->dp->org_structure;
                    if ($org1){
                        if ($org1->kod_dep === '082') continue; // юность
                    }
                    unset($pr_students[$key]);

                   continue;
                }

                $company_name = $pr_student->dp->company->name;

                if ($pr_student->dp->org_structure){
                    $company_name.= '('.$pr_student->dp->org_structure->name_short.')';
                }
            } else {
                $company_name = '_____________________';
            }
            $pr_student->company_name = $company_name;

            $teacher = $pr_student->teacher;

            if ($teacher)
            {
                $t_fio =    ($teacher->surname .' ' ?? ' ') .  ($teacher->firstname ? mb_substr($teacher->firstname, 0, 1, "UTF-8") .'.' : ' ') .  ($teacher->lastname ? mb_substr($teacher->lastname, 0, 1, "UTF-8") .'. ' : ' ');

            }
            else
            {
                $t_fio = '__________';
            }
            $pr_student->t_fio = $t_fio;
        }


        $s = Setting::key_val();

        if ($practice->education_type_id == 1){
            $mng_pr_fio = $s['mng_pr_fio_vo'] ?? '__________';
        } else {
            $mng_pr_fio = $s['mng_pr_fio_spo'] ?? '__________';
        }

        $order = $practice->orders()->first();

        $order_s = new \StdClass();
        if ($order) {
            $order_s->num = $order->num;
            $order_s->date = date('d.m.Y', strtotime($order->date));
        }
        else
        {
            $order_s->num = "_______";
            $order_s->date = '__.__.__';
        }

        // reference the Dompdf namespace

//
//// instantiate and use the dompdf class
//        $dompdf = new Dompdf();
//        //$dompdf->set_option('isHtml5ParserEnabled', true);
//        $dompdf->loadHtml(view('direction.print',['pr_students' => $pr_students, 'practice' => $practice, 'order_s' => $order_s, 'mng_pr_fio' => $mng_pr_fio]), 'utf-8');
//
//// (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('A4', 'landscape');
//
//// Render the HTML as PDF
//        $dompdf->render();
//
//// Output the generated PDF to Browser
//        $dompdf->stream();

         return view('direction.print',['pr_students' => $pr_students, 'practice' => $practice, 'order_s' => $order_s, 'mng_pr_fio' => $mng_pr_fio]);
    }
    public function generate($id)
    {
        try {


            $pr_student = PrStudent::findOrFail($id);

            $student = $pr_student->student;


            $s_fio = $student->fio() ?? 'ХХХХ';

            $practice =  $pr_student->practice;
            //Practice::findOrFail($id);
            $temp_name = 'direction_template.docx';
            $path = Storage::disk('agreements')->path("/templates/$temp_name");

            $docs = new  TemplateProcessor($path);
//            $this->prepaireSettings($docs);
            //производственная  - учебная

            $docs->setValue('s_fio', $s_fio);


            $docs->setValue('spec', $practice->spec ?? 'XX-XX-XX');
            $docs->setValue('pr_name', $practice->name ?? 'XX-XX-XX');
            $docs->setValue('course', $practice->course ?? 'XX');
            $docs->setValue('agroup', $practice->agroup ?? 'XX-XX-XX');

            $docs->setValue('date_start', $practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '__.__.__');
            $docs->setValue('date_end', $practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '__.__.__');


            if ($pr_student->dp) {
                $company_name = $pr_student->dp->company->name;

                if ($pr_student->dp->org_structure){
                    $company_name.= '('.$pr_student->dp->org_structure->name_short.')';
                }
            } else {
                $company_name = 'не определено';
            }

            $docs->setValue('company', $company_name);


            $order = $practice->orders()->first();

            if ($order) {
                $order_num = $order->num;
                $order_date = date('d.m.Y', strtotime($order->date));
            }
            else
            {
                $order_num = "ХХХ";
                $order_date = '__.__.__';
            }

            $docs->setValue('prik_num', $order_num );
            $docs->setValue('prik_date', $order_date );


            //$pr_studs = $practice->pr_students()->orderBy('distribution_practice_id')->get() ?? false;

            $s = Setting::key_val();

            if ($practice->education_type_id == 1){
                $mng_pr_fio = $s['mng_pr_fio_vo'] ?? 'ХХХ-ХХХ-ХХХ';
            } else {
                $mng_pr_fio = $s['mng_pr_fio_spo'] ?? 'ХХХ-ХХХ-ХХХ';
            }

            $docs->setValue('mng_pr_fio', $mng_pr_fio );

            $teacher = $pr_student->teacher;

            if ($teacher)
            {
                $t_fio =    ($teacher->surname .' ' ?? ' ') .  ($teacher->firstname ? mb_substr($teacher->firstname, 0, 1, "UTF-8") .'.' : ' ') .  ($teacher->lastname ? mb_substr($teacher->lastname, 0, 1, "UTF-8") .'. ' : ' ');

            }
            else
            {
                $t_fio = 'ХХХ';
            }

            $docs->setValue('t_fio', $t_fio );



            $doc_name = "Направление на практику $s_fio.docx";
            header('Content-Disposition: attachment;filename='.$doc_name);
            header('Cache-Control: max-age=0');
            $docs->saveAs('php://output');

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}

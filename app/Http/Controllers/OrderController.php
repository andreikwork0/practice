<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class OrderController extends Controller
{
    //


    private function teacherShort(Teacher $teacher){

        // фио short name
        $name = $teacher->firstname ?? false;
        $patronymic = $teacher->lastname ?? false;
        $fio_short =  ( $teacher->surname?? '') . ' '. ($name ? mb_substr($name, 0, 1, "UTF-8") .'.' : '') .  ($patronymic ? mb_substr($patronymic, 0, 1, "UTF-8") .'.' : '') ;

        return $fio_short . ' '. ($teacher->post ? mb_strtolower( $teacher->post, "UTF-8") : '');
    }

    public function generate($id)
    {
        try {

            $practice = Practice::findOrFail($id);
            $temp_name = 'prikaz_practice.docx';
            $path = Storage::disk('agreements')->path("/templates/$temp_name");

            $docs = new  TemplateProcessor($path);
//            $this->prepaireSettings($docs);
            //производственная  - учебная

            $pr_type = '_________';
            if ($practice->type) {
                if ($practice->type->id == 1) {
                    $pr_type = 'учебная';
                } else {
                    $pr_type = 'производственная';
                }
            }

            $docs->setValue('spec', $practice->spec ?? 'XX-XX-XX');
            $docs->setValue('pr_name', $practice->name ?? 'XX-XX-XX');
            $docs->setValue('course', $practice->course ?? 'XX');
            $docs->setValue('agroup', $practice->agroup ?? 'XX-XX-XX');
            $docs->setValue('depart_name', $practice->depart_name ?? 'XX-XX-XX');
            $docs->setValue('date_start', $practice->date_start ? date('d.m.Y', strtotime($practice->date_start)) : '__.__.__');
            $docs->setValue('date_end', $practice->date_end ? date('d.m.Y', strtotime($practice->date_end)) : '__.__.__');

            $docs->setValue('pr_form', $practice->practice_form_id  ? $practice->form->name : '_______');
            $docs->setValue('pr_type', $pr_type);


            $pulpit = $practice->pulpit;
            if ($pulpit){
                $pulpit_name = $pulpit->name;
            } else {
                $pulpit_name = '';
            }

            $docs->setValue('pulpit_name',$pulpit_name );
            $studs = array();
            $pr_studs = $practice->pr_students()->orderBy('distribution_practice_id')->get() ?? false;


            if($pr_studs){
                $i = 1;
                foreach ($pr_studs as $pr_stud){
                    $s = array();
                    $student = $pr_stud->student;
                    $org_name = '';
                    if ($student) {
                        $s['s_fio'] = $i .'. '. $student->fio();
                        if($pr_stud->dp){
                            if ($pr_stud->dp->company){
                                $org_name = $pr_stud->dp->company->name;

                                if ($pr_stud->dp->org_structure){
                                    $org_name .= '(' .$pr_stud->dp->org_structure->name_short .')';
                                }


                            }
                        }
                        $s['org_name'] = $org_name;
                    }
                    $studs[] = $s;
                    $i++;
                }
            }
            $docs->cloneRowAndSetValues('s_fio',$studs );

            $teachers = $practice->teachers;
            $t_str = '';
            foreach ($teachers as $teacher){
                $t_str .= $this->teacherShort($teacher) .', ';
            }

            if ($t_str) {
                $t_str =  rtrim($t_str, ", ");
            }



            $docs->setValue('teacher_str',$t_str. ' '. $pulpit_name );

            $fio_user = auth()->user()->name  ?? '';

            $docs->setValue('fio_user', $fio_user);

            $s = Setting::key_val();
            $docs->setValue('mng_job', $s['mng_job'] ?? 'XX-XX-XX');

            // фио short name
            $mng_name = $s['mng_fname'] ?? false;
            $mng_patronymic = $s['mng_mname'] ?? false;
            $mng_fio_short = ($mng_name ? mb_substr($mng_name, 0, 1, "UTF-8") .'. ' : '') .  ($mng_patronymic ? mb_substr($mng_patronymic, 0, 1, "UTF-8") .'. ' : '') . ' '. ($s['mng_lname'] ?? '');
            $docs->setValue('mng_fio_short',  $mng_fio_short);


            $doc_name = 'Приказ на практику.docx';
            header('Content-Disposition: attachment;filename='.$doc_name);
            header('Cache-Control: max-age=0');
            $docs->saveAs('php://output');

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}

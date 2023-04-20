<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Practice;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class OrderController extends Controller
{
    //


    public function destroy($id){
        $order = Order::findOrFail($id);
        $order->file->delete();
        return redirect()->back()->with(['success'=> 'Приказ успешно удален' ]);
    }


    public function index_one($pr_id)
    {
        $practice = Practice::find($pr_id);
        return view('orders.index_one', ['orders' => $practice->orders()->get() , 'practice' => $practice]);
    }


    public function edit($id){
        $order = Order::findOrFail($id);
        return view('orders.edit', ['order' => $order, 'practice' => $order->practice]);
    }


    public function update(Request $request, $id) {

        $order = Order::findOrFail($id);
        $pr_id = $order->practice->id;

        $request->validate([
            'date'      => 'required|date',
            'num'       => 'required|unique:orders,num,'. $order->id
        ]);

        $file = $request->file('order_f');
        $args = array(
            'num'           => $request->input('num'),
            'date'          => $request->input('date')
        );

        DB::beginTransaction();

        if ($file) {
            $fileModel =  FileController::upload($file, 'practices', function() use ($file, $pr_id){
                $hash_name = $file->hashName();
                return $pr_id .'/'.$hash_name;
            });
            if ($fileModel) {
                $args['file_id'] = $fileModel->id;
            }
        }
        $order->update($args);
        DB::commit();

        return redirect()->route('orders.index_one', $pr_id)->with(['success'=> 'Приказ успешно обновлен' ]);
    }

    public function store(Request  $request, $pr_id)
    {

        $file = $request->file('order_f');
        $request->validate([
            'date'      => 'required|date',
            'num'       => 'required|unique:orders,num',
            'order_f'   => 'required'
        ]);

        DB::beginTransaction();
        $fileModel =  FileController::upload($file, 'practices', function() use ($file, $pr_id){
                        $hash_name = $file->hashName();
                        return $pr_id .'/'.$hash_name;
                    });


        if ($fileModel) {
            Order::create([
                'num'           => $request->input('num'),
                'date'          => $request->input('date'),
                'practice_id'   => $pr_id,
                'file_id'       => $fileModel->id,
            ]);

            DB::commit();

            return redirect()->back()->with(['success'=> 'Приказ успешно добавлен' ]);
        }

    }

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

            $spec = $practice->spec;

            if ($spec ){
                if (strpos($spec, '.05.')) {
                    $prev_spec = 'специальности';
                } else {
                    $prev_spec = 'направления подготовки';
                }
                $spec = $prev_spec . ' '. $spec;
            } else  {
                $spec = 'XX-XX-XX';
            }

            $docs->setValue('spec', $spec);
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

            //$pr_studs = $practice->pr_students()->orderBy('distribution_practice_id')->get() ?? false;

            $s_array = array();


            if($pr_studs) {

                foreach ($pr_studs as $pr_stud) {
                    $student = $pr_stud->student;
                    if ($student) {
                        $pr_stud->fio_1 = $student->fio();
                    }
                    if ($pr_stud->dp) {
                        if ($pr_stud->dp->company) {

                            $org_name = $pr_stud->dp->company->name;
                            if ($pr_stud->dp->org_structure){
                                $orgs = $pr_stud->dp->org_structure;
                                if (str_contains($orgs->name, 'кафедра') || str_contains($orgs->name, 'Кафедра') ) {
                                    $org_name .= '( каф. ' .$orgs->name_short .')';
                                }
                                else{
                                    $org_name .= '(' .$orgs->name_short .')';
                                }

                            }

                            $s_array[$org_name][] = $pr_stud->fio_1;

                        }

                    }
                    else {
                        $s_array[' '][] = $pr_stud->fio_1;
                    }

                }

            }

            $n_array = array();
            foreach ($s_array as $key => $nested_arrays)
            {
                $collator = new \Collator('ru_RUS');
                $collator->sort($nested_arrays, \Collator::SORT_REGULAR);
                $n_array[$key] =$nested_arrays;
            }



            $i = 1;
            foreach ($n_array as $key => $n)
            {
                foreach ($n as $k => $v) {
                    $s = array();
                    $s['s_fio'] = $i .'. '. $v;
                    $s['org_name'] = $key;

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

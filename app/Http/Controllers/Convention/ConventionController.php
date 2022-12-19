<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Convention;
use App\Models\Setting;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ConventionController extends Controller
{

    protected $type = '';

    public function __construct($type = 'main')
    {
        $this->type = $type;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $ag_id)
    {

        $agreement = Agreement::findOrFail($ag_id);
        $request->validate([
            "conv_type_id-$ag_id" => 'required'
        ]);


        $conv_type_id = $request->input("conv_type_id-$ag_id");

        $res = Convention::where('agreement_id', 'like' , $ag_id)
            ->where('conv_type_id','=',$conv_type_id)
            ->orderBy('id', 'desc')->get()->first();
        if (is_null($res))  {
            $new_num = 0;
        } else {
            $new_num = $res->number + 1;
        }




        $conv =
            Convention::create([
                'number'        => $new_num,
                'conv_type_id'  => $conv_type_id,
                'agreement_id'  => $ag_id
            ]);

        return redirect(route('companies.show', ['company' => $agreement->company->id, 'agr' => $agreement->id]))->with('success', "Доп соглашение № $conv->number к $agreement->num_agreement  успешно добавлено");
    }

//
//
//    public function editing(Convention  $convention){
//
//        $convContr = ConvFactory::create($convention->type->slug);
//
//
//        return redirect('/conve/')->action([get_class($convContr), 'edit'], ["id" => $convention->id]);
////        ->edit($convention->id);
//    }


    protected function uploadFile(Request  $request, $convention) {

        $file =  $request->file('convention_f');

        $hash_name = $file->hashName();

        $content = $file->getContent();
        $agreement = $convention->agreement;
        $path = $agreement->id .'/'.$hash_name;

        Storage::disk('agreements')->put($agreement->id .'/'.$hash_name, $content);


        $convention->path = $path;
        $convention->save();


    }
    public function updating(Request $request, $id){


        $convention = Convention::findOrFail($id);
        $ars_is_active = array('is_actual' => $request->input('is_actual') ? 1 : 0);
        $convention->update(
            array_merge(    $request->except('convention_f'), $ars_is_active)
        );




        if ($request->hasFile('convention_f')) {


            $this->uploadFile($request, $convention);
        }


        return redirect(route('conventions.edit',     ["convention" => $convention->id ]))
            ->with('success', "Доп соглашение № $convention->number  успешно обновлено");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $convention = Convention::find($id);
        $company = $convention->company;
        if ($convention->path) {
            Storage::disk('agreements')->delete($convention->path); // удалить файл
        }

        $convention->delete();

        return redirect(route('companies.show', $company->id))->with('success', 'Доп соглашение успешно удалено');

    }

    public function download( $id){


        $convention = Convention::find($id);
        $agreement = $convention->agreement;
        $num =  $agreement->num_agreement;
        $com_name = $agreement->company->name;
        $com_name = str_replace('"', '', $com_name);
        $path = $convention->path;
        $extension = explode('.', $path);
        $extension = $extension[1];
//        $extension =  Storage::disk('agreements')->extension( $path); //\extension( $path);


        $num = str_replace('/', '_', $num);
        $num = str_replace("\\", '_', $num);

        $com_name = str_replace('"', '', $com_name);
        $com_name = str_replace(',', '', $com_name);

        $date_from = date('d.m.Y', strtotime($agreement->date_agreement));


        $dp_num = $this->format_title($convention);

        return Storage::disk('agreements')->download($path, "$dp_num к договору № $num  c $com_name от $date_from .$extension" );

    }

    public function format_title($convention){
        //
        if ($convention->type->add_num) {
            if($convention->number > 0 ) {
                $dp_num  = 'Доп соглашение № '. $convention->number;
                $dp_num .= ' к приложению № ' .  $convention->type->add_num;

            } else {
                $dp_num = 'Приложение № ' .  $convention->type->add_num;
            }
        } else {
            $dp_num = 'Доп соглашение № ' . $convention->number;
        }
        return $dp_num;
    }

    public function docs_set_default(&$docs, $conv){
        //
        $ag_num = $conv->agreement->num_agreement ??  '__';
        $docs->setValue('ag_num',$ag_num );
//
        $ag_date = $conv->agreement->date_agreement ? date('d.m.Y', strtotime($conv->agreement->date_agreement)) : '__.__.__';
        $docs->setValue('ag_date', $ag_date);
//

        $dp_num = $this->format_title($conv);
        //

        $docs->setValue('dp_num',$dp_num );


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




        $ag_num = str_replace('/', '_', $ag_num);
        $ag_num = str_replace("\\", '_', $ag_num);

        $name_dpagr = "$dp_num к договору № $ag_num .docx";

        return  $name_dpagr;
    }

}

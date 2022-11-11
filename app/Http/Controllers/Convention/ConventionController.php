<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Convention;
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



        $res = Convention::where('agreement_id', 'like' , $ag_id)->orderBy('id', 'desc')->get()->first();
        if (is_null($res))  {
            $new_num = 1;
        } else {
            $new_num = $res->number + 1;
        }


        $conv_type_id = $request->input("conv_type_id-$ag_id");

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
        $path = $convention->id .'/'.$hash_name;
        Storage::disk('agreements')->put($convention->id .'/'.$hash_name, $content);


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


        $date_from = date('d.m.Y', strtotime($agreement->date_agreement));

        return Storage::disk('agreements')->download($path, "Доп соглашение № $convention->number к договору № $num  c $com_name от $date_from .$extension" );

    }

}

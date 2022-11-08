<?php

namespace App\Http\Controllers\Convention;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Convention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function download($id){

    }

}

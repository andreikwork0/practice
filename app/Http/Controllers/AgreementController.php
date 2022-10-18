<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgrStatus;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agreement.index', ['agreements' => Agreement::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $com_id)
    {
        $company = Company::findOrFail($com_id);
        $statuses = AgrStatus::all();

        return view('agreement.create', ['statuses' => $statuses, "company" => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $com_id)
    {
        //
//        dd($request->file('agreement_f'));


        $company = Company::findOrFail($com_id);



        $ars_is_active = array('is_actual' => $request->input('is_actual') ? 1 : 0);
        $agreement = $company->agreements()->create(
         array_merge(    $request->except('agreement_f'), $ars_is_active)
        );

        $is_upload = false;

        if ($request->hasFile('agreement_f')) {
            $file =  $request->file('agreement_f');
            $hash_name = $file->hashName();
            $content = $file->getContent();

            $path = $agreement->id .'/'.$hash_name;

            $is_upload =     Storage::disk('agreements')->put(
                $agreement->id .'/'.$hash_name, $content);

        }

        if ($is_upload) {

            $agreement->path = $path;
            $agreement->save();
        }

        $num = $agreement->generateNum();
        $agreement->num_agreement = $num;
        $agreement->save();

        return redirect(route('companies.show', $company->id))->with('success', 'Договор успешно добавлен');


//        dd($agreement);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // download linker
    public function download($id) {

        // check

        $agreement = Agreement::find($id);
        $path = $agreement->path;
        $extension =  'docx'; //\extension( $path);

        return Storage::disk('agreements')->download($path, "Договор.$extension" );


    }
}

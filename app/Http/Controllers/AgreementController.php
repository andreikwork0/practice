<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgrStatus;
use App\Models\Company;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $this->customValidateRequest($request);

        $company = Company::findOrFail($com_id);

        $agrs =   array('is_actual' =>    0,  'agr_status_id' => 1);
        $agreement = $company->agreements()->create(
         array_merge(    $request->all(), $agrs)
        );



        $agreement->num_agreement = $this->getNextNum($request->input('date_bg'));
        $agreement->save();

        return redirect(route('companies.show', $company->id))->with('success', 'Договор успешно добавлен');

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
        $agreement = Agreement::findOrFail($id);
        $statuses = AgrStatus::all();
        return view('agreement.edit', ['agreement' => $agreement, 'statuses' => $statuses]);
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

        $this->customValidateRequest($request);


        $agreement = Agreement::findOrFail($id);


        $ars_is_active = array('is_actual' => $request->input('is_actual') ? 1 : 0);
        $agreement->update(
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

        return redirect(route('companies.show', $agreement->company->id))->with('success', "Договор $agreement->num_agreement  успешно обновлен");



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agr = Agreement::find($id);
        $company = $agr->company;
        Storage::disk('agreements')->deleteDirectory($agr->id); // удалить папку
        $agr->delete();

        return redirect(route('companies.show', $company->id))->with('success', 'Договор успешно удален');

    }

    protected function customValidateRequest(Request  $request){

        $request->validate([
            'date_agreement'  => 'nullable|date|before_or_equal:date_bg',
            'date_bg'  => 'required|date',
            'date_end' =>  'nullable|date|after_or_equal:date_bg',
        ]);
    }

    // download linker
    public function download($id) {


        $agreement = Agreement::find($id);
        $num =  $agreement->num_agreement;
        $com_name = $agreement->company->name;
        $com_name = str_replace('"', '', $com_name);
        $path = $agreement->path;
        $extension = explode('.', $path);
        $extension = $extension[1];
//        $extension =  Storage::disk('agreements')->extension( $path); //\extension( $path);
        $name = "Договор № $num $com_name.$extension";

        $date_from = date('d.m.Y', strtotime($agreement->date_agreement));

        return Storage::disk('agreements')->download($path, "Договор № $num  c $com_name от $date_from .$extension" );


    }

    protected function getNextNum($date_bg)
    {


        $date = new Carbon( $date_bg );
        $year = $date->format('y');


        // поиск id по этому году
        $res = Agreement::where('num_agreement', 'like' , "%-$year")->orderBy('id', 'desc')->get()->first();

        if (is_null($res))  {
            $new_num = 1;
        } else {
            $arr_code =  explode('-', $res->num_agreement);
            $new_num = $arr_code[1] + 1;
        }

        return  'ПП' . '-' . $new_num  . '-'. $year;

    }
//    protected function formateDoc(){
//        try {
//
//            $doc_path =('../../report/magtu_antiplagiat/docs/journal_norm.docx');
//
//            $templateProcessor = new  TemplateProcessor($doc_path);
//
//
//            $name_kaf = $report->records[0]->name_kaf;
//            $short_name = $report->records[0]->short_name;
//
//            if ($name_kaf){
//                $templateProcessor->setValue('name_kaf', $name_kaf);
//            }
//
//            if ($short_name){
//                $templateProcessor->setValue('short_name', $short_name);
//            }
//            $rows = [];
//            foreach ($report->records as $rec){
//                $row = [];
//                $row['spec'] = $rec->spec;
//                $row['namegr'] = $rec->namegr;
//                $row['fio'] = $rec->fio;
//                $row['fname'] = $rec->fname;
//                $row['date_finish'] = $rec->date_finish;
//                $row['persent'] = $rec->persent . ' %';
//                $row['res'] = $rec->res;
//                $rows[] = $row;
//            }
//
//
//
//            $templateProcessor->cloneRowAndSetValues('spec', $rows);
//
//            header('Content-Disposition: attachment;filename="'.'Журнал регистрации проверок .docx'.'"');
//
//            header('Cache-Control: max-age=0');
//            $templateProcessor->saveAs('php://output');
//
//
//
//
//
//        } catch (Exception $e){
//            var_dump($e->getMessage());
//        }
//    }

}

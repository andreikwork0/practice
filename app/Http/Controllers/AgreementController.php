<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgrStatus;
use App\Models\Company;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;
use Staticall\Petrovich\Petrovich\Ruleset;


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
    public function generate($id){
        try {

            $agreement = Agreement::findOrFail($id);
            $path = Storage::disk('agreements')->path('/templates/agreement.docx');

            $docs = new  TemplateProcessor($path);

            $docs->setValue('num_agreement',  $agreement->num_agreement  ?? 'XX-XX-XX');


            $docs->setValue('date_agreement', $agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : 'XX-XX-XX');

            $company = $agreement->company;

            // должен быть родительный падеж
            $com_mng_fio = ($company->mng_surname ?? '') . ' ' . ($company->mng_name ?? '') . ' ' . ($company->mng_patronymic ?? '');
            if ($company->mng_patronymic) {
                $gender =  Petrovich::detectGender($company->mng_patronymic);
                $petrovich = new Petrovich(Loader::load(__DIR__ .'/../../../vendor/cloudloyalty/petrovich-rules/rules.json'));
                $com_mng_fio = $petrovich->inflectFullName($com_mng_fio, Ruleset::CASE_GENITIVE, $gender);
            }
            //
            $docs->setValue('com_mng_fio', $com_mng_fio);

            if ($company->name_full){
                $com_name_full  = $company->name_full;
                $com_name = "($company->name)";
            } else {
                $com_name_full  = '';
                $com_name  = $company->name;
            }
            $docs->setValue('com_name', $com_name);
            $docs->setValue('com_name_full', $com_name_full);



            $docs->setValue('agr_date_bg', $agreement->date_bg ? date('d.m.Y', strtotime($agreement->date_bg)) : 'XX-XX-XX');
            $docs->setValue('agr_date_end', $agreement->date_end ? date('d.m.Y', strtotime($agreement->date_end)) : 'XX-XX-XX');



            $docs->setValue('com_legal_adress',  $company->legal_adress  ?? 'XX-XX-XX');
            $docs->setValue('com_inn',  $company->inn  ? ('ИНН: ' .  $company->inn) : '');
            $docs->setValue('com_kpp',  $company->kpp  ? ('КПП: ' .  $company->kpp) : '');
            $docs->setValue('com_ch_account',  $company->ch_account  ? ('Р/C: ' .  $company->ch_account) : '');
            $docs->setValue('com_cr_account',  $company->cr_account  ? ('К/С: ' .  $company->cr_account) : '');
            $docs->setValue('com_bik',  $company->bik  ? ('БИК: ' .  $company->bik) : '');


            // фио short name
            $mng_name = $company->mng_name ?? false;
            $mng_patronymic = $company->mng_patronymic ?? false;
            $com_mng_fio_short = ($mng_name ? mb_substr($mng_name, 0, 1, "UTF-8") .'. ' : '') .  ($mng_patronymic ? mb_substr($mng_patronymic, 0, 1, "UTF-8") .'. ' : '') . ' '. ($company->mng_surname ?? '');
            $docs->setValue('com_mng_fio_short',  $com_mng_fio_short);

            $df = $agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : 'XX-XX-XX';
            $name_agr = "Договор № $agreement->num_agreement  c $company->name от $df .docx";
            header('Content-Disposition: attachment;filename='.$name_agr);
            header('Cache-Control: max-age=0');
            $docs->saveAs('php://output');

        } catch (\Exception $e){
            var_dump($e->getMessage());
        }
    }

}

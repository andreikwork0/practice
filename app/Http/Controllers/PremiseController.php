<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Premise;
use Illuminate\Http\Request;

class PremiseController extends Controller
{
    public function list($id)
    {
        $company = Company::findOrFail($id);
        return view('company.tabs.premises', ['company' => $company ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $premise = $company->premises()->create(  $request->all());
        return redirect(route('premises.list', $company->id))->with('success', 'Помещение успешно добавлено');

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
        $premise = Premise::findOrFail($id);
        return view('premise.edit', [ "pm" => $premise]);
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
        $premise = Premise::findOrFail($id);
        $company = $premise->company;
        $premise->update($request->all());

        return redirect()->route('premises.list', $company->id )->with('success', "Помещение обновлено");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pm = Premise::find($id);
        $name = $pm->name;
        $company = $pm->company;
        $pm->delete();
        return redirect()->route('premises.list', $company->id )->with('success', "Помещение $name удалено");
    }

    protected function customValidateRequest(Request $request){
        $args =  array(
            'name' => 'required|max:255',
        );

        $request->validate( $args);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.index', ['companies' => Company::orderby('name')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create', ['companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->valideRequest($request);
        $company = Company::create($request->all());
        return redirect()->route('companies.index')->with('success', "Организация $company->name добавлена");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('company.show', ['company' => Company::find($id), 'companies' => Company::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('company.edit', ['company' => Company::findOrFail($id),
                                            'companies' => Company::all()->except($id)]);
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
        $company = Company::findOrFail($id);
        $this->valideRequest($request);
        $company->update($request->all());
        return redirect()->route('companies.edit', $company)->with('success', "Организация обновлена");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $name = $company->name;
        $company->delete();
        return redirect()->route('companies.index')->with('success', "Организация удалена $name");
    }

    public function valideRequest(Request $request){
        $request->validate([
            'name' => 'required|max:100',
            'legal_adress' => 'required|max:200',
            'fact_adress' => 'max:200',
            'mng_surname' => 'required|max:20',
            'mng_name' => 'required|max:20',
            'mng_patronymic' => 'max:20',
            'inn' => 'required|max:12',
            'kpp' => 'required|max:12',
            'ch_account' => 'max:70',
            'cr_account' => 'max:30',
            'bik' => 'max:100'
        ]);
    }
}

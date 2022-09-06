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
        return view('company.create');
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
        return view('company.show', ['company' => Company::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('company.edit', ['company' => Company::find($id)]);
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
        $company = Company::find($id);
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
            'legal_adress' => 'required|max:100',
            'mng_surname' => 'required|max:20',
            'mng_name' => 'required|max:20',
            'mng_patronymic' => 'required|max:20',
            'inn' => 'required|max:6',
            'kpp' => 'required|max:10',
            'ch_account' => 'required|max:70',
            'cr_account' => 'required|max:30',
            'bik' => 'required|max:100'
        ]);
    }
}

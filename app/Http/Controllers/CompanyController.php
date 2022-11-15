<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ConvType;
use App\Models\Country;
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
        return view('company.index', ['companies' =>
            Company::filter(request(['search', 'dp_new'] ))
            ->withCount(['dist_pr as new_dp' => function ($query) {
                $query->whereNull('convention_id');
            }])
            ->orderby('name')
            ->paginate(10)
            ->withQueryString(), 'dp_new_c' => MainController::countNewDistPractice()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create', ['companies' => Company::all(), 'countries' => Country::all() ]);
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

        $conv_types = ConvType::all();



        return view('company.tabs.agreements', ['company' => Company::find($id), 'companies' => Company::all(), 'conv_types' => $conv_types ]);
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
                                            'companies' => Company::all()->except($id),
                                            'countries' => Country::all()
        ]);
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
        $this->valideRequest($request, $company);
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

    public function valideRequest(Request $request, Company $company = null){


        if(    $request->input('country_id') == 185) { // если страна россия
            if (empty($request->input('parent_id'))) { // если головная организация

                if ($company){ // update
                    $arr_inn = array(
                        'inn' => 'required|max:12|unique:companies,inn,'. $company->id,
                        'kpp' => 'required|max:12',
                    );
                } else { // store
                    $arr_inn = array(
                        'inn' => 'required|max:12|unique:companies',
                        'kpp' => 'required|max:12',
                    );
                }

            } else {
                // если филиал_подразделение
                $arr_inn = array(
                    'inn' => 'required|max:12',
                    'kpp' => 'required|max:12',
                );
            }
        } else {
            // если другая страна
            $arr_inn = array();
        }

        $args =  array(
            'name' => 'required|max:255',
            'legal_adress' => 'required|max:200',
            'fact_adress' => 'max:200',
            'mng_surname' => 'required|max:40',
            'mng_name' => 'required|max:40',
            'mng_patronymic' => 'max:40',
            'ch_account' => 'max:70',
            'cr_account' => 'max:30',
            'bik' => 'max:100'
        );

        $request->validate( array_merge($arr_inn, $args));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ContactPerson;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{

    public function list($id)
    {
        $company = Company::findOrFail($id);
        return view('company.tabs.contact_person', ['company' => $company ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact_person.index', ['contact_people' => ContactPerson::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $com_id)
    {
        $company = Company::findOrFail($com_id);
        return view('contact_person.create', [ "company" => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $com_id)
    {

       // $this->customValidateRequest($request);

        $company = Company::findOrFail($com_id);

        $is_negotiation =  $request->input('is_negotiation') ? 1 : 0;
        $agrs =   array('is_negotiation' =>    $is_negotiation,);
        $agreement = $company->contact_people()->create(
            array_merge(    $request->all(), $agrs)
        );

        return redirect(route('contact_people.list', $company->id))->with('success', 'Контакт успешно добавлен');

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
        $cp = ContactPerson::findOrFail($id);
        return view('contact_person.edit', [ "cp" => $cp]);

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
        $cp = ContactPerson::findOrFail($id);
        //$this->valideRequest($request);
        $cp->update($request->all());
        return redirect()->route('contact_people.list', $cp->company->id)->with('success', "Контакт обновлен");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cp = ContactPerson::find($id);
        $name = $cp->name;
        $company = $cp->company;
        $cp->delete();
        return redirect()->route('contact_people.list', $company->id )->with('success', "Контакт удален $cp");
    }
}

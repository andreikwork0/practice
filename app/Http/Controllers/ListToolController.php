<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ListTool;
use App\Models\TCategory;
use App\Models\Tool;
use Illuminate\Http\Request;

class ListToolController extends Controller
{

    public function list($id)
    {
        $company = Company::findOrFail($id);

        $list_tools = $company->list_tool;

        $t_categories = TCategory::query()->where('is_active', '=',1)->get();

        return view('company.tabs.tools', ['company' => $company, 'list_tools' => $list_tools, 't_categories' => $t_categories ]);
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
    public function store(Request $request, $id)
    {
        $tool = Tool::where('name', $request->name)->get();
        if ($tool->count() > 0 ) {
            $tool = $tool->first();
            $tool_id = $tool->id;
        } else {
           $tool = Tool::create(['name' => $request->name, 't_category_id' => $request->t_category_id]);
           $tool_id = $tool->id;
        }
        ListTool::create([
            'company_id'  => $id,
            'tool_id'     => $tool_id,
        ]);

        return redirect(route('list_tool.list', $id))->with('success', 'Средство успешно добавлено');
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
        $lt = ListTool::find($id);
        $name = $lt->name;
        $company = $lt->company;
        $lt->delete();
        return redirect()->route('list_tool.list', $company->id )->with('success', "Средство $name удалено");
    }
}

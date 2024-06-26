<?php

namespace App\Http\Controllers;

use App\Exports\ToolsExport;
use App\Models\TCategory;
use App\Models\Tool;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tools = Tool::query()
            ->orderby('name', 'asc')
            ->filter(request(['search']))
            ->paginate(10)
            ->withQueryString();

        return view('tool.index', ['tools' =>  $tools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $t_categories = TCategory::query()->where('is_active', '=',1)->get();

        return view('tool.create', ['t_categories' => $t_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $args = $request->validate([
            'name'              => 'required|unique:tools,name',
            't_category_id'     => ''
        ]);
        $tool = Tool::create($args);

        return redirect()->route('tools.create')->with('success', "Средство - $tool->name - обучения успешно добавлено");

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

        $t_categories = TCategory::query()->where('is_active', '=',1)->get();
        $tool = Tool::findOrFail($id);
        return view('tool.edit', ['tool' => $tool, 't_categories' => $t_categories ]);

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
        $tool = Tool::find($id);
        $args = $request->validate([
            'name'              => 'required|unique:tools,name,'.$id,
            't_category_id'     => ''
        ]);
        $tool->update($args);

        return redirect()->route('tools.index')->with('success', "Средство - $tool->name - обучения успешно обновлено");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tool = Tool::find($id);
        $t_name = $tool->name;
        $tool->delete();
        return redirect()->route('tools.index')->with('success', "Средство - $t_name - обучения успешно удалено");

    }


    public function export()
    {
        return Excel::download(new ToolsExport, 'tools.xlsx');
    }

}

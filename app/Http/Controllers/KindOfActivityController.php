<?php

namespace App\Http\Controllers;

use App\Models\KindOfActivity;
use App\Models\Spec;
use Illuminate\Http\Request;

class KindOfActivityController extends Controller
{


    protected function getSpecsList()
    {
        $specs = Spec::where('education_type_id','=',2)->get();

        $arr_specs = [];

        foreach ($specs as $spec)
        {
            $tmp_obj = new \StdClass();
            $tmp_obj->id = $spec->id;
            $tmp_obj->name = $spec->full_name();
            $arr_specs[]= $tmp_obj;
        }

        return $arr_specs; // view
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // KindOfActivity::filter()

        return view('kind_of_activity.index', ['kind_of_activities' =>
            KindOfActivity::filter(request(['search', 'spec_id'] ))
                ->orderby('name')
                ->paginate(10)
                ->withQueryString(), 'specs' => $this->getSpecsList() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('kind_of_activity.create', ['specs' => $this->getSpecsList() ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate

        $vr = KindOfActivity::where('code', '=', $request->code)->where('spec_id', '=', $request->spec_id)->first();

        if ($vr)
        {
            return redirect()->route('kind_of_activities.create')
                ->withErrors( [ 'kof_unique' => "Код специальности и код вида деятельности должны быть уникальными"]);

        }


        $KindOfActivity = KindOfActivity::create($request->all());

        return redirect()->route('kind_of_activities.index')
                            ->with('success', "Вид деятельности успешно добавлен");
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


        $KindOfActivity = KindOfActivity::findOrFail($id);
        return view('kind_of_activity.edit', [ 'kind_of_activity' => $KindOfActivity, 'specs' => $this->getSpecsList() ]);
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


        $vr = KindOfActivity::where('code', '=', $request->code)->where('spec_id', '=', $request->spec_id)->where('id','<>', $id)->first();

        if ($vr)
        {
            return redirect()->route('kind_of_activities.edit', $id)
                ->withErrors( [ 'kof_unique' => "Код специальности и код вида деятельности должны быть уникальными"]);

        }
        $KindOfActivity = KindOfActivity::findOrFail($id);
        $KindOfActivity->update($request->all());


        return redirect()->route('kind_of_activities.index')
            ->with('success', "Вид деятельности успешно обновлен");
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
}

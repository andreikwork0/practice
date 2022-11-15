<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index', ['settings' => Setting::paginate(50)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:settings', // уникальное
            'name' => 'required',
            'title' => 'required',
        ]);

        $slug = trim(str_replace(' ','_', $request->input('slug')));
        $slug = trim(str_replace('-','_', $slug));
        $args = array(
          'slug' => $slug,
          'name' => $request->input('name'),
          'title' => $request->input('title'),
        );
        $setting = Setting::create($args);

        return redirect()->route('settings.index')->with('success', "Настройка $setting->name успешно добавлена");
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
        $setting = Setting::findOrFail($id);
        return view('setting.edit', ['setting' => $setting] );
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
        $setting = Setting::findOrFail($id);
        $request->validate([
          //  'slug' => 'required|unique:settings,slug,'.$setting->id,
            'name' => 'required',
            'title' => 'required',
        ]);
        $setting->update($request->except('slug'));

        return redirect()->route('settings.index')->with('success', "Настройка $setting->name успешно обновлена");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);

        $name = $setting->name;
        $setting->delete();

        return redirect()->route('settings.index')->with('success', "Настройка $name успешно удалена");
    }
}

<?php

namespace App\Http\Controllers\Convention;

use App\Models\Convention;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class ConventionOthController extends ConventionController implements ConventionInterface
{

    public function edit($id)
    {
        $conv = Convention::findOrFail($id);
        return view('convention.types.oth', ['convention' => $conv ]);
    }

    public function update(Request $request, $id)
    {
        $conv = Convention::findOrFail($id);
        $conv->text = $request->input('text') ?? NULL;

        $conv->save();

        return redirect()->route('conventions.edit', $id)->with('success', 'Информация успешно обновлена');


    }



    public function generate($id)
    {
        $conv =  Convention::findOrFail($id);

        $temp_name = $conv->type->template;
        $path = Storage::disk('agreements')->path("/templates/$temp_name");

        $docs = new  TemplateProcessor($path);



        $name_dpagr =  $this->docs_set_default($docs, $conv);

        $docs->setValue('text',$conv->text );

//


        $name_dpagr = str_replace('"', '', $name_dpagr);
        $name_dpagr = str_replace(',', '', $name_dpagr);

        header('Content-Disposition: attachment;filename='.$name_dpagr);
        header('Cache-Control: max-age=0');
        $docs->saveAs('php://output');
    }
}

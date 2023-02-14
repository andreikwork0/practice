<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{


    public function download($id)
    {
        $file = File::find($id);
        return Storage::disk($file->disk)->download($file->path, $file->name );
    }


    public static function upload($file, $disk = 'public', $path_callback = null) : File
    {

        if (is_callable($path_callback)) {
            $path =  $path_callback();
            $content = $file->getContent();
            Storage::disk($disk)->put($path, $content);
        } else {
            $path = Storage::putFile($disk, $file);
        }

        return
            File::create([
                'disk' => $disk,
                'name' => $file->getClientOriginalName(),
                'hash_name' => $file->hashName(),
                'path' => $path,
                'ext' =>  $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
            ]);

    }


}

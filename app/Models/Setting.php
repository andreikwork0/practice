<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];


    static public  function key_val()
    {
       $arr = [];
       $settings = Setting::all();
       foreach ($settings as $setting)
       {
           $arr[$setting->slug] =  $setting->name;
       }

       return $arr;
    }
}

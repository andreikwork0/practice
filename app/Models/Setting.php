<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    static public function by_slug($slug)
    {
        return  Setting::where('slug', '=', $slug)->first()->name;
    }
}

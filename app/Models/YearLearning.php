<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearLearning extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function activeYear(){
        return YearLearning::where("active", 1)->get()[0];
    }


}

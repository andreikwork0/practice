<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use App\Models\Practice;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public static function countNewDistPractice() {
//        $conv_count_vo = DistributionPractice::filter(['conv_null' => 'on'])->where('education_type_id', '=', '1')->count();
//        $conv_count_vo = DistributionPractice::filter(['conv_null' => 'on'])->where('education_type_id', '=', '1')->count();
//        $conv_count_spo = DistributionPractice::filter(['conv_null' => 'on'])->where('education_type_id', '=', '2')->count();


        $conv_count_vo =  DistributionPractice::whereHas('practice' , function ($query) {
            $query->where('education_type_id', '=', 1);
        })->filter(['conv_null' => 'on'])->count();

        $conv_count_spo =  DistributionPractice::whereHas('practice' , function ($query) {
            $query->where('education_type_id', '=', 2);
        })->filter(['conv_null' => 'on'])->count();


        $conv_count = $conv_count_vo. ' / '. $conv_count_spo;
        return $conv_count;
    }
}

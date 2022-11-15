<?php

namespace App\Http\Controllers;

use App\Models\DistributionPractice;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public static function countNewDistPractice() {
        $conv_count = DistributionPractice::filter(['conv_null' => 'on'])->count();
        return $conv_count;
    }
}

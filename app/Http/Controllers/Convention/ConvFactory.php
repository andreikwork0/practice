<?php

namespace App\Http\Controllers\Convention;

class ConvFactory
{

    public static function create($type)
    {
        switch ($type)
        {
            case 'edu' : return new ConventionEduController($type);
                break;
            case 'prem' : return new ConventionPremController($type);
                break;
            case 'oth':   return  new ConventionOthController($type);
                break;

        }
    }
}

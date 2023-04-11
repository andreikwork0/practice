<?php

namespace App\Import;


use App\Models\Spec;
use Illuminate\Support\Facades\DB;

class SpecImport
{
    protected $settings;
    public function __construct($settings = [])
    {
        if (empty($settings)) {
            $settings = array(
                ['connection' => 'mysql_load',
                    'ed_type' =>    1 ],
                ['connection' => 'mysql_load_spo',
                    'ed_type' =>    2 ],
            );
        }
        $this->settings = $settings;
    }

    public  function run()
    {

        // выкачать студентов
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
        }


    }




    private function import($connection , $education_type_id  ){ // specs


        if ($education_type_id == 1) {
            $sql2 = "SELECT * FROM direction
                     WHERE code NOT LIKE '%.02.%'";
        }
        else {
            $sql2 = "SELECT * FROM direction";
        }


        $specs = DB::connection($connection)->select($sql2);



        foreach( $specs as $spec)
        {


            $sModel = Spec::where('code', '=', $spec->code)->first();


            if ($sModel) {
                $sModel->name = $spec->name;
                $sModel->save();
            }
            else {
                Spec::create([
                    'education_type_id' => $education_type_id,
                    'code'             => $spec->code,
                    'name'             => $spec->name
                ]);
            }


        }

    }


}

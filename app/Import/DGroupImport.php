<?php

namespace App\Import;

use App\Models\DGroup;
use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;
use App\Models\StudentTmp;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class DGroupImport
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
        // почистить временную таблицу
        DGroup::query()->delete();

        // выкачать группы
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['ed_type'],
            );
        }


    }





    private function import($connection , $education_type_id  ){


        $year_learning = YearLearning::activeYear();
        if ($education_type_id ==  1) {
            //$day_sql = "pp.day as day,";
            $id_year_learning = $year_learning->l_id_vo;
        } else{
            //$day_sql = "";
            $id_year_learning = $year_learning->l_id_spo;
        }

        $sql2 = "
        select
               child.expr1 as name,
               child.id as g_id,
               concat(g_p.name,'-',year,'-',number) as parent_name,
               g_p.id as g_parent_id
        from `groups` as g_p inner join (
        select id, id_parent, concat(name, '-', year,'-', number) as expr1 from `groups`
        where id_parent <> 0 and id_year_learning = ".$id_year_learning." ) as child
          on child.id_parent  = `g_p`.id
        ";

        $dgroups = DB::connection($connection)->select($sql2);
        foreach( $dgroups as $dgroup){
            $array = array(
                'name' =>  $dgroup->name,
                'parent_name'  => $dgroup->parent_name,
                'g_id' =>  $dgroup->g_id,
                'g_parent_id' => $dgroup->g_parent_id,
                'education_type_id' => $education_type_id
            );
            DGroup::create($array );

        }

    }


}

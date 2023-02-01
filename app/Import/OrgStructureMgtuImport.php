<?php

namespace App\Import;


use App\Models\Company;
use App\Models\OrgStructure;
use App\Models\Practice;
use App\Models\PracticeTmp;
use App\Models\Pulpit;

use App\Models\Setting;
use App\Models\Teacher;
use App\Models\YearLearning;
use Illuminate\Support\Facades\DB;

class OrgStructureMgtuImport
{
    protected $settings;
    public function __construct($settings = [])
    {

        if (empty($settings)) {
            $s = Setting::key_val();
            $settings = array(
                ['connection' => 'shtat_sqlsrv', 'org_id' =>  $s['univer_id'] ]
            );
        }
        $this->settings = $settings;
    }

    public  function run()
    {

        // выкачать группы
        foreach ($this->settings as $setting) {
            $this->import(
                $setting['connection'],
                $setting['org_id'],
            );
        }
    }


    private function import($connection , $company_id  )
    {
        $company = Company::findOrFail($company_id);
        $version = $company->org_structure_version;
        $version++;


        $orgs =
        DB::connection($connection)->select(
            "SELECT
                    [Kod_Dep]      ,[Name_Dep]       ,[ShotName_Dep] ,[KodParent_Dep]     ,[IsActiv]
              FROM [shtat].[dbo].[StructVUZ]
              WHERE   IsActiv = 1
              order by KodParent_Dep"
        );

        foreach ($orgs as $org) {
            OrgStructure::create(
                [
                    'name' => $org->Name_Dep ?? '',
                    'name_short' => $org->ShotName_Dep ?? '',
                    'kod_dep' => $org->Kod_Dep,
                    'kod_dep_parent' => $org->KodParent_Dep,
                    'company_id' => $company_id,
                    'version' => $version,
                ]
            );
        }

    DB::connection('mysql')->update(
        "
        update org_structures as s1
             inner join org_structures as s2  on s2.kod_dep = s1.kod_dep_parent and s2.version = s1.version and   s2.company_id = s1.company_id
         set s1.org_structure_id = s2.id
        where s1.version=".$version." and s1.company_id=".$company_id
    );
    $company->org_structure_version = $version;
    $company->save();

    }

}

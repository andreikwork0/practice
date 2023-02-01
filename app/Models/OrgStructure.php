<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgStructure extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, array  $filters){

        $query->where('is_active', '=', 1);
        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where( fn($query) =>
            $query->where('name', 'like', '%'. $search  .'%')
            );
        });


        $query->when($filters['company'] ?? false, function($query, $company){
            $com1 = Company::findOrFail($company);
            $version = $com1->org_structure_version;
            $query->where( fn($query) =>
                $query->where('company_id', '=', $company)
                    ->where('version', '=', $version)
            );
        });
    }
}

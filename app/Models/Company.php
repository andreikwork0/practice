<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function scopeFilter($query, array  $filters){

        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where( fn($query) =>
            $query->where('name', 'like', '%'. $search  .'%')

            );

        });
    }


    public function contact_people()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function grn_letters()
    {
        return $this->hasMany(GrnLetter::class);
    }

    public function premises()
    {
        return $this->hasMany(Premise::class);
    }

    public function  dist_pr(){
        return $this->hasMany(DistributionPractice::class);
    }
}

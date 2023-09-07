<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulpit extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeFilter($query, array  $filters){

        $active_year = YearLearning::activeYear();
        $query->when($filters['ed_type'] ?? 1, function($query, $ed_type){
            $query->where( fn($query) =>
                $query->where('education_type_id', '=', $ed_type  )
            );
        });

        $query->when($filters['year'] ?? $active_year->id, function($query, $year){
            $query->where( fn($query) =>
                $query->where('year_learning_id', '=', $year  )
            );
        });
    }

    public function getByCodeParent()
    {
        return  $this::where('code', '=', $this->code)->where('education_type_id', '=', $this->education_type_id )->max('id');
    }

}

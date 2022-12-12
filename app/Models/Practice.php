<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;
    protected $guarded = [];
//    protected  $dates = ['date_start', 'date_end'];
//
//    protected $dateFormat = 'd.m.Y';



    public function dp(){
        return $this->hasMany(DistributionPractice::class);
    }

    public function type()
    {
        return $this->belongsTo(PracticeType::class, 'practice_type_id', 'id', 'practice_types');
    }



    public function scopeFilter($query, array  $filters){

        $active_year = YearLearning::activeYear();
        $query->when($filters['ed_type'] ?? false, function($query, $ed_type){
            $query->where( fn($query) =>
            $query->where('education_type_id', '=', $ed_type  )
            );
        });


        $query->when($filters['pr_state'] ?? 'n', function($query, $pr_state){
            $query->where( fn($query) =>
            $query->where('pr_state', '=', $pr_state  )
            );
        });


        $query->when($filters['year'] ?? $active_year->id, function($query, $year){
            $query->where( fn($query) =>
            $query->where('year_learning_id', '=', $year  )
            );
        });
        $query->when($filters['pulpit'] ?? false, function($query, $pulpit){
            $query->where( fn($query) =>
            $query->where('pulpit_id', '=', $pulpit  )
            );
        });

        $query->when($filters['course'] ?? false, function($query, $course){
            $query->where( fn($query) =>
            $query->where('course', '=', $course  )
            );
        });

        $query->when($filters['semester'] ?? false, function($query, $semester){
            $query->where( fn($query) =>
            $query->where('semester', '=', $semester  )
            );
        });

    }

}

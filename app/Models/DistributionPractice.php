<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionPractice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, array  $filters){

        $query->when($filters['ag_null'] ?? false, function($query, $ag_null){
            $query->where( fn($query) =>
            $query->whereNull('agreement_id')
            );

        });
    }


    public function practice(){

        return $this->belongsTo(Practice::class);
    }

    public function company(){

        return $this->belongsTo(Company::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

}

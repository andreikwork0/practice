<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrStudent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function dp(){
        return $this->belongsTo(DistributionPractice::class, 'distribution_practice_id', 'id');
    }

}

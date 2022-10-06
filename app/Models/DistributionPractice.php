<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionPractice extends Model
{
    use HasFactory;

    protected $guarded = [];

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

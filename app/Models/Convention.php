<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convention extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type(){
        return $this->belongsTo(ConvType::class, 'conv_type_id', 'id');
    }

    public function agreement(){
        return $this->belongsTo(Agreement::class);
    }

    public function company()
    {
        if ($this->agreement()) {
            return $this->agreement->company();
        }
        return null;

    }

    public function dist_pr(){
        return $this->hasMany(DistributionPractice::class);
    }

    public function premises()
    {
        return $this->belongsToMany(Premise::class);
    }

}

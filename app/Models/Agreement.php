<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function status(){
        return $this->belongsTo(AgrStatus::class, 'agr_status_id', 'id');
    }

    public function type(){
        return $this->belongsTo(AgrTypes::class, 'agr_type_id', 'id' );
    }

    public function conventions(){
        return $this->hasMany(Convention::class);
    }


}

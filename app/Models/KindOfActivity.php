<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KindOfActivity extends Model
{
    use HasFactory;



    protected $guarded = [];

    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }

    public function full_name()
    {
        return $this->code . ' '. $this->name;
    }


    public function scopeFilter($query, array  $filters){

        $query->when($filters['search'] ?? false, function($query, $search){

            $query->where( fn($query) =>
            $query->where('name', 'like', '%'. $search  .'%'));


        });

        $query->when($filters['spec_id'] ?? false, function($query, $spec_id){

            $query->where( fn($query) =>
            $query->where('spec_id', '=', $spec_id));


        });

    }

}

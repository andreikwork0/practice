<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['full_name'];
    public function scopeFilter($query, array  $filters){

        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where( fn($query) =>
            $query->where('name', 'like', '%'. $search  .'%') );
        });
    }


    public function getFullNameAttribute()
    {
        if ($this->t_category){
            return $this->t_category->name .': '. $this->name;
        }
        return $this->name;
    }

    public function t_category()
    {
        return $this->belongsTo(TCategory::class);
    }
}

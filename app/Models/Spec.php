<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function full_name()
    {
        return $this->code . ' '. $this->name;
    }

    public function kind_of_activities()
    {
        return $this->hasMany(KindOfActivity::class);
    }
}

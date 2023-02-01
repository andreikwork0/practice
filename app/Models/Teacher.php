<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fio(){
        return $this->surname .' ' . $this->firstname . ' ' . ($this->lastname ?? '');
    }





    public function practices()
    {
        return $this->belongsToMany(Practice::class, 'practice_teacher');
    }
}

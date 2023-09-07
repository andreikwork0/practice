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


    public function pulpit(){
        return $this->belongsTo(Pulpit::class);
    }


    public function upTeacher()
    {

       $new_id_pulpit  =  $this->pulpit->getByCodeParent() ?? NULL;

       return
       Teacher::query()->where('pulpit_id', '=', $new_id_pulpit)
                        ->where('surname', '=', $this->surname)
                        ->where('firstname', '=', $this->firstname)
                        ->where('lastname' , '=', $this->lastname )->first() ?? NULL;
    }



    public function practices()
    {
        return $this->belongsToMany(Practice::class, 'practice_teacher');
    }
}

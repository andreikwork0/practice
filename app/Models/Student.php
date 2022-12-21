<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function fio(){
        return $this->family .' ' . $this->name1 . ' ' . ($this->name2 ?? '');
    }
}

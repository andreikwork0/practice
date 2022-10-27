<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;

    protected $guarded =[];
    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function fio(){
        return $this->prs_lname . ' ' . $this->prs_fname . ' ' .  ($this->prs_sname ?? '');
    }
}

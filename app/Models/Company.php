<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function contact_people()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function grn_letters()
    {
        return $this->hasMany(GrnLetter::class);
    }
}

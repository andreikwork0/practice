<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTool extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'org_structure_id', 'tool_id'];

    public function company()
    {
       return $this->belongsTo(Company::class);
    }

    public function org_structure()
    {
       return $this->belongsTo(OrgStructure::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

}

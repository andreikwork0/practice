<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [];
//    protected $fillable = [
//        'name',
//        'email',
//        'username',
//        'password',
//    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isRole($name){

//        if ($name == 'kaf' && !($this->pulpit_id)) return false;

        $role =   $this->role;
        if ($role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function education_type()
    {
        return $this->belongsTo(EducationType::class);
    }

    public function pulpit()
    {
        return $this->belongsTo(Pulpit::class);
    }

    public function scopeFilter($query, array  $filters){

        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where( fn($query) =>
                $query->where('fname', 'like',  "%$search%"  )
                       ->orWhere('lname', 'like',  "%$search%"  )
                       ->orWhere('mname', 'like',  "%$search%"  )
            );
        });
    }

}

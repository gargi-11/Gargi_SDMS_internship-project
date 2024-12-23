<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}


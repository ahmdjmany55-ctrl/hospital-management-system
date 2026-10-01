<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [

        'name',

        'email',

        'role',

        'password',

    ];


    protected $hidden = [

        'password',

        'remember_token',

    ];


    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

        ];
    }


    public function doctor()
    {
        return $this->hasOne(
            Doctor::class
        );
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }


    public function isReceptionist(): bool
    {
        return $this->role === 'receptionist';
    }
}

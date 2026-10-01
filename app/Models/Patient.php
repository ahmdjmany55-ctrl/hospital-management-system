<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Appointment;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'department_id',
        'medical_history',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

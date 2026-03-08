<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'test_id',
        'employee_id',
        'appointment_date',
        'appointment_time',
        'status',
        'test_type',
        'admin_notes',
    ];

    // Relationship with Test
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    // Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Register::class, 'patient_id');
    }

    // Relationship with Employee (optional)
    public function employee()
    {
        return $this->belongsTo(Register::class, 'employee_id');
    }
}


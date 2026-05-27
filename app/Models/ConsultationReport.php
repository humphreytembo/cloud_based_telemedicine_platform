<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationReport extends Model
{
    protected $fillable = [
    'appointment_id',
    'doctor_id',
    'patient_id',
    'blood_pressure',
    'temperature',
    'weight',
    'heart_rate',
    'diagnosis',
    'prescription',
    'notes',
    'follow_up_date',
    'follow_up_instructions',
    'status',
];
    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
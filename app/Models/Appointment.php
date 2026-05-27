<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'reminder_sent',
    ];

    protected $casts = [
        // ✅ No date cast on appointment_date — keep it as plain string
        // so concatenating with appointment_time works without double datetime
        'reminder_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function report()
    {
        return $this->hasOne(ConsultationReport::class);
    }

    // Combined datetime accessor — use $appointment->datetime anywhere
    public function getDatetimeAttribute(): Carbon
    {
        return Carbon::parse($this->appointment_date . ' ' . $this->appointment_time);
    }
}
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Appointment;
use App\Services\ResendEmailService;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $emailService = app(ResendEmailService::class);

            $targetTime = Carbon::now()->addHour();

            $appointments = Appointment::with(['doctor', 'patient'])
                ->where('status', 'approved')
                ->where('reminder_sent', false)
                ->whereBetween(
                    \DB::raw("CONCAT(appointment_date, ' ', appointment_time)"),
                    [
                        $targetTime->copy()->subMinutes(2)->format('Y-m-d H:i:s'),
                        $targetTime->copy()->addMinutes(2)->format('Y-m-d H:i:s'),
                    ]
                )
                ->get();

            foreach ($appointments as $appointment) {
                $data = [
                    'doctor_name'      => $appointment->doctor->name,
                    'doctor_email'     => $appointment->doctor->email,
                    'patient_name'     => $appointment->patient->name,
                    'patient_email'    => $appointment->patient->email,
                    'appointment_date' => Carbon::parse($appointment->appointment_date)->format('l, F j, Y'),
                    'appointment_time' => Carbon::parse($appointment->appointment_time)->format('g:i A'),
                    'join_link'        => url("/consultation/join/{$appointment->id}"),
                ];

                $emailService->sendAppointmentReminder($data, 'both');

                $appointment->update(['reminder_sent' => true]);
            }

        })->everyMinute()->name('send-appointment-reminders')->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
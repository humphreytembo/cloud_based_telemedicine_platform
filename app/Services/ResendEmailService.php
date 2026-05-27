<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResendEmailService
{
    private string $apiKey;
    private string $fromEmail;
    private string $fromName;

    public function __construct()
    {
        $this->apiKey    = config('resend.api_key');
        $this->fromEmail = config('resend.from_email');
        $this->fromName  = config('resend.from_name');
    }

    /**
     * Send a raw email via Resend API.
     */
   public function send(string $to, string $subject, string $body): bool
{
    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.resend.com/emails', [
            'from'    => "{$this->fromName} <{$this->fromEmail}>",
            'to'      => [$to],
            'subject' => $subject,
            'html'    => $body,
        ]);

        if ($response->successful()) {
            Log::info('Resend email sent', ['to' => $to, 'id' => $response->json('id')]);
            return true;
        }

        Log::error('Resend API error', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);
        return false;

    } catch (\Exception $e) {
        Log::error('Resend exception: ' . $e->getMessage());
        return false;
    }
}
    /**
     * Notify doctor of a new appointment.
     */
    public function sendDoctorAppointmentNotification(array $data): bool
    {
        $html = view('emails.doctor_appointment', $data)->render();
        return $this->send(
            $data['doctor_email'],
            "📅 New Appointment — {$data['patient_name']} on {$data['appointment_date']}",
            $html
        );
    }

    /**
     * Send confirmation email to the patient.
     */
    public function sendPatientConfirmation(array $data): bool
    {
        $html = view('emails.patient_confirmation', $data)->render();
        return $this->send(
            $data['patient_email'],
            "✅ Appointment Confirmed with Dr. {$data['doctor_name']}",
            $html
        );
    }

    /**
     * Send appointment reminder (call this 1 hour before via scheduler).
     */
    public function sendAppointmentReminder(array $data, string $recipientType = 'both'): bool
    {
        $success = true;

        if (in_array($recipientType, ['doctor', 'both'])) {
            $html = view('emails.reminder', array_merge($data, ['recipient_type' => 'doctor']))->render();
            $success &= $this->send(
                $data['doctor_email'],
                "⏰ Reminder: Appointment in 1 Hour — {$data['patient_name']}",
                $html
            );
        }

        if (in_array($recipientType, ['patient', 'both'])) {
            $html = view('emails.reminder', array_merge($data, ['recipient_type' => 'patient']))->render();
            $success &= $this->send(
                $data['patient_email'],
                "⏰ Reminder: Your Appointment with Dr. {$data['doctor_name']} in 1 Hour",
                $html
            );
        }

        return (bool) $success;
    }

    /**
     * Send cancellation email to both doctor and patient.
     */
    public function sendCancellationNotification(array $data): bool
    {
        $success = true;

        // Notify doctor
        $html = view('emails.cancellation', array_merge($data, ['recipient_type' => 'doctor']))->render();
        $success &= $this->send(
            $data['doctor_email'],
            "❌ Appointment Cancelled — {$data['patient_name']}",
            $html
        );

        // Notify patient
        $html = view('emails.cancellation', array_merge($data, ['recipient_type' => 'patient']))->render();
        $success &= $this->send(
            $data['patient_email'],
            "❌ Your Appointment with Dr. {$data['doctor_name']} Has Been Cancelled",
            $html
        );

        return (bool) $success;
    }
}

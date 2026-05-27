<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Services\ResendEmailService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct(private ResendEmailService $emailService) {}

    // ─── Show Booking Form ─────────────────────────────────────────────────────

    public function create()
    {
        $doctors = User::where('role', 'doctor')
                        ->where('is_approved', 1)
                        ->get();

        return view('appointments.book', compact('doctors'));
    }

    // ─── Store Appointment ─────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason'           => 'required|string',
        ]);

        $appointment = Appointment::create([
            'patient_id'       => Auth::id(),
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        $doctor  = User::find($request->doctor_id);
        $patient = Auth::user();

        $emailData = $this->buildEmailData($appointment, $doctor, $patient);

        $this->emailService->sendDoctorAppointmentNotification($emailData);
        $this->emailService->sendPatientConfirmation($emailData);

        return back()->with('success', 'Appointment request sent!');
    }

    // ─── Doctor Dashboard ──────────────────────────────────────────────────────

    public function dashboard()
    {
        $appointments = Appointment::with(['patient', 'report'])
            ->where('doctor_id', auth()->id())
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }

    // ─── Patient Appointments ──────────────────────────────────────────────────

    public function index()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with(['doctor', 'patient', 'report'])
            ->latest()
            ->get()
            ->map(function ($appointment) {
                // Parse date + time in app timezone, convert to UTC ISO for JS
                $appointment->appointment_iso = Carbon::parse(
                    $appointment->appointment_date . ' ' . $appointment->appointment_time,
                    config('app.timezone')
                )->utc()->toIso8601String();

                return $appointment;
            });

        return view('appointments.index', compact('appointments'));
    }

    // ─── Approve Appointment ───────────────────────────────────────────────────

    public function approve($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);

        $appointment->update(['status' => 'approved']);

        $emailData = $this->buildEmailData($appointment, $appointment->doctor, $appointment->patient);

        $this->emailService->send(
            $appointment->patient->email,
            '✅ Your Appointment Has Been Approved — TeleMed',
            view('emails.appointment_approved', $emailData)->render()
        );

        return back()->with('success', 'Appointment approved');
    }

    // ─── Reject Appointment ────────────────────────────────────────────────────

    public function reject($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);

        $appointment->update(['status' => 'rejected']);

        $emailData = $this->buildEmailData($appointment, $appointment->doctor, $appointment->patient);

        $this->emailService->sendCancellationNotification($emailData);

        return back()->with('error', 'Appointment rejected');
    }

    // ─── Reschedule Appointment ────────────────────────────────────────────────

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);

        if ($appointment->doctor_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->status           = 'rescheduled';
        $appointment->save();

        $emailData = $this->buildEmailData($appointment, $appointment->doctor, $appointment->patient);

        $this->emailService->send(
            $appointment->patient->email,
            '🗓️ Your Appointment Has Been Rescheduled — TeleMed',
            view('emails.appointment_rescheduled', $emailData)->render()
        );

        return back()->with('success', 'Appointment rescheduled successfully');
    }

    // ─── Helper: Build Email Data ──────────────────────────────────────────────

    private function buildEmailData(Appointment $appointment, User $doctor, User $patient): array
    {
        return [
            'doctor_name'      => $doctor->name,
            'doctor_email'     => $doctor->email,
            'doctor_specialty' => $doctor->specialty ?? 'General Practitioner',
            'patient_name'     => $patient->name,
            'patient_email'    => $patient->email,
            'appointment_date' => date('l, F j, Y', strtotime($appointment->appointment_date)),
            'appointment_time' => $appointment->appointment_time,
            'reason'           => $appointment->reason,
            'appointment_id'   => $appointment->id,
            'join_link'        => url("/consultation/join/{$appointment->id}"),
        ];
    }
}
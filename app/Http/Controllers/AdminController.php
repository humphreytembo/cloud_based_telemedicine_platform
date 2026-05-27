<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $pendingDoctors = User::where('role', 'doctor')
            ->where('is_approved', false)
            ->where('status', '!=', 'rejected')
            ->get();

        $totalPatients = User::where('role', 'patient')->count();

        $totalDoctors = User::where('role', 'doctor')
            ->where('is_approved', true)
            ->count();

        $totalAppointments = Appointment::count();

        $todayAppointments = Appointment::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        $totalReports = ConsultationReport::count();

        return view('admin.dashboard', compact(
            'pendingDoctors',
            'totalPatients',
            'totalDoctors',
            'totalAppointments',
            'todayAppointments',
            'totalReports'
        ));
    }

    public function approve($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->status = 'approved';
        $doctor->is_approved = true;
        $doctor->save();

        return back()->with('success', 'Doctor approved successfully');
    }

    public function reject($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->status = 'rejected';
        $doctor->is_approved = false;
        $doctor->save();

        return back()->with('success', 'Doctor rejected successfully');
    }

    public function pendingDoctors()
    {
        $doctors = User::where('role', 'doctor')
            ->where('is_approved', false)
            ->where('status', '!=', 'rejected')
            ->get();

        return view('admin.doctors.pending', compact('doctors'));
    }

    public function approvedDoctors()
    {
        $doctors = User::where('role', 'doctor')
            ->where('is_approved', true)
            ->get();

        return view('admin.doctors.approved', compact('doctors'));
    }

    public function patients()
    {
        $patients = User::where('role', 'patient')->get();

        return view('admin.patients.index', compact('patients'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->latest()
            ->get();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function deleteDoctor($id)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($id);

        if ($doctor->profile_image) {
            \Storage::delete('public/' . $doctor->profile_image);
        }

        if ($doctor->doctor_document) {
            \Storage::delete('public/' . $doctor->doctor_document);
        }

        $doctor->delete();

        return back()->with('success', 'Doctor deleted successfully');
    }

    public function deletePatient($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);
        $patient->delete();

        return back()->with('success', 'Patient deleted successfully');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ConsultationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsultationReportController extends Controller
{
    // ─── Doctor: Show Report Form ──────────────────────────────────────────────
    public function create($appointmentId)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($appointmentId);

        // Only the assigned doctor can create the report
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Prevent duplicate reports
        if ($appointment->report) {
            return redirect()->route('reports.show', $appointment->report->id)
                ->with('info', 'Report already exists.');
        }

        return view('reports.create', compact('appointment'));
    }

    // ─── Doctor: Store Report ──────────────────────────────────────────────────
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'diagnosis'              => 'required|string',
            'prescription'           => 'nullable|string',
            'notes'                  => 'nullable|string',
            'follow_up_date'         => 'nullable|date',
            'follow_up_instructions' => 'nullable|string',
            'status'                 => 'required|in:draft,published',
        ]);

        $report = ConsultationReport::create([
            'appointment_id'         => $appointment->id,
            'doctor_id'              => $appointment->doctor_id,
            'patient_id'             => $appointment->patient_id,
            'diagnosis'              => $request->diagnosis,
            'prescription'           => $request->prescription,
            'notes'                  => $request->notes,
            'follow_up_date'         => $request->follow_up_date,
            'follow_up_instructions' => $request->follow_up_instructions,
            'status'                 => $request->status,
        ]);

        return redirect()->route('reports.show', $report->id)
            ->with('success', 'Report saved successfully.');
    }

    // ─── Patient: Update Vitals ────────────────────────────────────────────────
    public function updateVitals(Request $request, $reportId)
    {
        $report = ConsultationReport::findOrFail($reportId);

        // Only the patient of this report can update vitals
        if ($report->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'blood_pressure' => 'nullable|string',
            'temperature'    => 'nullable|string',
            'weight'         => 'nullable|string',
            'heart_rate'     => 'nullable|string',
        ]);

        $report->update([
            'blood_pressure' => $request->blood_pressure,
            'temperature'    => $request->temperature,
            'weight'         => $request->weight,
            'heart_rate'     => $request->heart_rate,
        ]);

        return back()->with('success', 'Vitals updated successfully.');
    }

    // ─── View Report (Doctor, Patient, Admin) ─────────────────────────────────
    public function show($id)
    {
        $report = ConsultationReport::with(['appointment', 'doctor', 'patient'])->findOrFail($id);

        $user = Auth::user();

        // Only doctor, patient, or admin can view
        if (
            $user->role !== 'admin' &&
            $report->doctor_id !== $user->id &&
            $report->patient_id !== $user->id
        ) {
            abort(403, 'Unauthorized');
        }

        return view('reports.show', compact('report'));
    }

    // ─── Admin: View All Reports ───────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $reports = ConsultationReport::with(['doctor', 'patient', 'appointment'])
                ->latest()
                ->get();
        } elseif ($user->role === 'doctor') {
            $reports = ConsultationReport::with(['patient', 'appointment'])
                ->where('doctor_id', $user->id)
                ->latest()
                ->get();
        } else {
            $reports = ConsultationReport::with(['doctor', 'appointment'])
                ->where('patient_id', $user->id)
                ->where('status', 'published')
                ->latest()
                ->get();
        }

        return view('reports.index', compact('reports'));
    }

    // ─── Doctor: Edit Report ───────────────────────────────────────────────────
    public function edit($id)
    {
        $report = ConsultationReport::with('appointment')->findOrFail($id);

        if ($report->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('reports.edit', compact('report'));
    }

    // ─── Doctor: Update Report ─────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $report = ConsultationReport::findOrFail($id);

        if ($report->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'diagnosis'              => 'required|string',
            'prescription'           => 'nullable|string',
            'notes'                  => 'nullable|string',
            'follow_up_date'         => 'nullable|date',
            'follow_up_instructions' => 'nullable|string',
            'status'                 => 'required|in:draft,published',
        ]);

        $report->update($request->only([
            'diagnosis',
            'prescription',
            'notes',
            'follow_up_date',
            'follow_up_instructions',
            'status',
        ]));

        return redirect()->route('reports.show', $report->id)
            ->with('success', 'Report updated successfully.');
    }
    

// ─── Download Report as PDF ────────────────────────────────────────────────
public function downloadPdf($id)
{
    $report = ConsultationReport::with(['appointment', 'doctor', 'patient'])->findOrFail($id);

    $user = Auth::user();

    // Only doctor, patient, or admin can download
    if (
        $user->role !== 'admin' &&
        $report->doctor_id !== $user->id &&
        $report->patient_id !== $user->id
    ) {
        abort(403, 'Unauthorized');
    }

    $pdf = Pdf::loadView('reports.pdf', compact('report'));

    return $pdf->download('consultation-report-#'.$report->id.'.pdf');
}
}
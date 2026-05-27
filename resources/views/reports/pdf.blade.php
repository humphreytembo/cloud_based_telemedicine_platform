<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>Consultation Report #{{ $report->id }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 13px;
        color: #1a2332;
        padding: 40px;
    }

    .header {
        border-bottom: 3px solid #1565c0;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 22px;
        color: #1565c0;
        margin-bottom: 4px;
    }

    .header p {
        font-size: 12px;
        color: #7a8fa6;
    }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .badge-published { background: #e8f5e9; color: #2e7d32; }
    .badge-draft { background: #fff9c4; color: #f57f17; }

    .info-grid {
        width: 100%;
        margin-bottom: 24px;
    }

    .info-grid td {
        width: 50%;
        vertical-align: top;
        padding: 16px;
        background: #f7faff;
        border: 1px solid #e2ecff;
    }

    .info-grid .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #7a8fa6;
        margin-bottom: 4px;
    }

    .info-grid .value {
        font-size: 14px;
        font-weight: bold;
        color: #1a2332;
    }

    .info-grid .sub {
        font-size: 11px;
        color: #7a8fa6;
    }

    .section {
        margin-bottom: 20px;
        border: 1px solid #e2ecff;
        border-left: 4px solid #1565c0;
        border-radius: 4px;
        padding: 16px;
    }

    .section h2 {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #1565c0;
        margin-bottom: 10px;
    }

    .section p {
        font-size: 13px;
        color: #1a2332;
        line-height: 1.7;
    }

    .vitals-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }

    .vitals-table td {
        padding: 10px 16px;
        border: 1px solid #e2ecff;
        font-size: 13px;
    }

    .vitals-table td:first-child {
        color: #7a8fa6;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: 40%;
        background: #f7faff;
    }

    .footer {
        margin-top: 40px;
        border-top: 1px solid #e2ecff;
        padding-top: 16px;
        text-align: center;
        font-size: 11px;
        color: #a0aec0;
    }
</style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>⚕ TeleMed — Consultation Report</h1>
        <p>Report #{{ $report->id }} &nbsp;|&nbsp;
           {{ \Carbon\Carbon::parse($report->appointment->appointment_date)->format('l, F j, Y') }}
           at {{ $report->appointment->appointment_time }}
           &nbsp;|&nbsp;
           <span class="badge {{ $report->status === 'published' ? 'badge-published' : 'badge-draft' }}">
               {{ ucfirst($report->status) }}
           </span>
        </p>
    </div>

    {{-- Doctor & Patient --}}
    <table class="info-grid">
        <tr>
            <td>
                <div class="label">Doctor</div>
                <div class="value">Dr. {{ $report->doctor->name }}</div>
                <div class="sub">{{ $report->doctor->specialty ?? 'General Practitioner' }}</div>
                <div class="sub">{{ $report->doctor->email }}</div>
            </td>
            <td>
                <div class="label">Patient</div>
                <div class="value">{{ $report->patient->name }}</div>
                <div class="sub">{{ $report->patient->email }}</div>
            </td>
        </tr>
    </table>

    {{-- Diagnosis --}}
    <div class="section">
        <h2>Diagnosis</h2>
        <p>{{ $report->diagnosis }}</p>
    </div>

    {{-- Prescription --}}
    @if($report->prescription)
    <div class="section">
        <h2>Prescription / Medication</h2>
        <p>{{ $report->prescription }}</p>
    </div>
    @endif

    {{-- Notes --}}
    @if($report->notes)
    <div class="section">
        <h2>Additional Notes</h2>
        <p>{{ $report->notes }}</p>
    </div>
    @endif

    {{-- Follow Up --}}
    @if($report->follow_up_date)
    <div class="section">
        <h2>Follow-Up</h2>
        <table class="vitals-table">
            <tr>
                <td>Follow-Up Date</td>
                <td>{{ \Carbon\Carbon::parse($report->follow_up_date)->format('l, F j, Y') }}</td>
            </tr>
            @if($report->follow_up_instructions)
            <tr>
                <td>Instructions</td>
                <td>{{ $report->follow_up_instructions }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    {{-- Vitals --}}
    @if($report->blood_pressure || $report->temperature || $report->weight || $report->heart_rate)
    <div class="section">
        <h2>Patient Vitals (Self-Reported)</h2>
        <table class="vitals-table">
            @if($report->blood_pressure)
            <tr><td>Blood Pressure</td><td>{{ $report->blood_pressure }}</td></tr>
            @endif
            @if($report->temperature)
            <tr><td>Temperature</td><td>{{ $report->temperature }}</td></tr>
            @endif
            @if($report->weight)
            <tr><td>Weight</td><td>{{ $report->weight }}</td></tr>
            @endif
            @if($report->heart_rate)
            <tr><td>Heart Rate</td><td>{{ $report->heart_rate }}</td></tr>
            @endif
        </table>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>This report was generated by <strong>TeleMed Platform</strong> on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>For medical inquiries contact <strong>support@telemed.com</strong></p>
    </div>

</body>
</html>
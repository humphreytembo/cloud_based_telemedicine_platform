<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Consultation Report</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-700 rounded-full p-3 text-2xl">📋</div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Consultation Report #{{ $report->id }}</h1>
                    <p class="text-sm text-gray-500">{{ $report->appointment->appointment_date }} at {{ $report->appointment->appointment_time }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $report->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ ucfirst($report->status) }}
            </span>
        </div>
    </div>

    {{-- Doctor & Patient Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Doctor</h2>
            <p class="font-semibold text-gray-800">Dr. {{ $report->doctor->name }}</p>
            <p class="text-sm text-gray-500">{{ $report->doctor->specialty ?? 'General Practitioner' }}</p>
            <p class="text-sm text-gray-500">{{ $report->doctor->email }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Patient</h2>
            <p class="font-semibold text-gray-800">{{ $report->patient->name }}</p>
            <p class="text-sm text-gray-500">{{ $report->patient->email }}</p>
        </div>
    </div>

    {{-- Diagnosis --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Diagnosis</h2>
        <p class="text-gray-700 leading-relaxed">{{ $report->diagnosis }}</p>
    </div>

    {{-- Prescription --}}
    @if($report->prescription)
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Prescription / Medication</h2>
        <p class="text-gray-700 leading-relaxed">{{ $report->prescription }}</p>
    </div>
    @endif

    {{-- Notes --}}
    @if($report->notes)
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Additional Notes</h2>
        <p class="text-gray-700 leading-relaxed">{{ $report->notes }}</p>
    </div>
    @endif

    {{-- Follow Up --}}
    @if($report->follow_up_date)
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-3">Follow-Up</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Date</p>
                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($report->follow_up_date)->format('l, F j, Y') }}</p>
            </div>
            @if($report->follow_up_instructions)
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Instructions</p>
                <p class="text-gray-700">{{ $report->follow_up_instructions }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Patient Vitals --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xs font-semibold text-blue-700 uppercase tracking-widest mb-1">Patient Vitals</h2>
        <p class="text-xs text-gray-400 mb-4">Self-reported by patient (optional)</p>

        @if($report->blood_pressure || $report->temperature || $report->weight || $report->heart_rate)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @if($report->blood_pressure)
            <div class="bg-blue-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-700">{{ $report->blood_pressure }}</p>
                <p class="text-xs text-gray-500 mt-1">Blood Pressure</p>
            </div>
            @endif
            @if($report->temperature)
            <div class="bg-orange-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-orange-600">{{ $report->temperature }}</p>
                <p class="text-xs text-gray-500 mt-1">Temperature</p>
            </div>
            @endif
            @if($report->weight)
            <div class="bg-green-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $report->weight }}</p>
                <p class="text-xs text-gray-500 mt-1">Weight</p>
            </div>
            @endif
            @if($report->heart_rate)
            <div class="bg-red-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $report->heart_rate }}</p>
                <p class="text-xs text-gray-500 mt-1">Heart Rate</p>
            </div>
            @endif
        </div>
        @else
        <p class="text-sm text-gray-400 italic">No vitals submitted by patient.</p>
        @endif

        {{-- Patient vitals form --}}
        @if(Auth::id() === $report->patient_id)
        <form action="{{ route('reports.vitals', $report->id) }}" method="POST" class="mt-6 border-t pt-4">
            @csrf
            <p class="text-sm font-semibold text-gray-700 mb-3">Update Your Vitals</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <label class="text-xs text-gray-400">Blood Pressure</label>
                    <input type="text" name="blood_pressure" value="{{ $report->blood_pressure }}" placeholder="e.g. 120/80" class="w-full border border-gray-200 rounded-lg p-2 text-sm mt-1"/>
                </div>
                <div>
                    <label class="text-xs text-gray-400">Temperature (°C)</label>
                    <input type="text" name="temperature" value="{{ $report->temperature }}" placeholder="e.g. 36.6" class="w-full border border-gray-200 rounded-lg p-2 text-sm mt-1"/>
                </div>
                <div>
                    <label class="text-xs text-gray-400">Weight (kg)</label>
                    <input type="text" name="weight" value="{{ $report->weight }}" placeholder="e.g. 70kg" class="w-full border border-gray-200 rounded-lg p-2 text-sm mt-1"/>
                </div>
                <div>
                    <label class="text-xs text-gray-400">Heart Rate (bpm)</label>
                    <input type="text" name="heart_rate" value="{{ $report->heart_rate }}" placeholder="e.g. 72" class="w-full border border-gray-200 rounded-lg p-2 text-sm mt-1"/>
                </div>
            </div>
            <button type="submit" class="mt-4 px-5 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700">
                Save Vitals
            </button>
        </form>
        @endif
    </div>

    {{-- Actions --}}
    <div class="flex gap-3 justify-end mb-10">
        @if(Auth::id() === $report->doctor_id)
        <a href="{{ route('reports.edit', $report->id) }}" class="px-5 py-2 rounded-xl border border-blue-300 text-blue-700 text-sm hover:bg-blue-50">
            ✏️ Edit Report
        </a>
        @endif
        <a href="{{ route('reports.index') }}" class="px-5 py-2 rounded-xl border border-gray-200 text-gray-600 text-sm hover:bg-gray-50">
            ← Back to Reports
        </a>
        <a href="{{ url('/reports/'.$report->id.'/pdf') }}" class="px-5 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700">
            ⬇️ Download PDF
        </a>
    </div>

</div>
</body>
</html>
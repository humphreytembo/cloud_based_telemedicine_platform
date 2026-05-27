<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Create Consultation Report</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6 flex items-center gap-4">
        <div class="bg-blue-100 text-blue-700 rounded-full p-3 text-2xl">📋</div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Consultation Report</h1>
            <p class="text-sm text-gray-500">Appointment with {{ $appointment->patient->name }} on {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }} at {{ $appointment->appointment_time }}</p>
        </div>
    </div>

    {{-- Success / Error --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 rounded-xl px-4 py-3 mb-4">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 rounded-xl px-4 py-3 mb-4">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.store', $appointment->id) }}" method="POST">
        @csrf

        {{-- Diagnosis --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-sm font-semibold text-blue-700 uppercase tracking-widest mb-4">Diagnosis</h2>
            <textarea
                name="diagnosis"
                rows="4"
                placeholder="Enter diagnosis details..."
                class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                required
            >{{ old('diagnosis') }}</textarea>
        </div>

        {{-- Prescription --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-sm font-semibold text-blue-700 uppercase tracking-widest mb-4">Prescription / Medication</h2>
            <textarea
                name="prescription"
                rows="4"
                placeholder="List medications, dosage, and frequency..."
                class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            >{{ old('prescription') }}</textarea>
        </div>

        {{-- Notes --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-sm font-semibold text-blue-700 uppercase tracking-widest mb-4">Additional Notes</h2>
            <textarea
                name="notes"
                rows="3"
                placeholder="Any additional observations or notes..."
                class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            >{{ old('notes') }}</textarea>
        </div>

        {{-- Follow Up --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-sm font-semibold text-blue-700 uppercase tracking-widest mb-4">Follow-Up</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide mb-1 block">Follow-Up Date (optional)</label>
                    <input
                        type="date"
                        name="follow_up_date"
                        value="{{ old('follow_up_date') }}"
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide mb-1 block">Follow-Up Instructions (optional)</label>
                    <input
                        type="text"
                        name="follow_up_instructions"
                        value="{{ old('follow_up_instructions') }}"
                        placeholder="e.g. Return in 2 weeks for checkup"
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                    />
                </div>
            </div>
        </div>

        {{-- Status & Submit --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <label class="text-xs text-gray-500 uppercase tracking-wide mb-1 block">Report Status</label>
                <select name="status" class="border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="draft">Save as Draft</option>
                    <option value="published">Publish to Patient</option>
                </select>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('doctor.dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                    Save Report
                </button>
            </div>
        </div>

    </form>
</div>

</body>
</html>
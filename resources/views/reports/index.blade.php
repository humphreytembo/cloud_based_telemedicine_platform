<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Consultation Reports</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">

<div class="max-w-5xl mx-auto">

    {{-- Back to Dashboard --}}
    <div class="mb-5">
        <a href="{{ Auth::user()->role === 'doctor' ? route('doctor.dashboard') : route('home') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 bg-white px-4 py-2.5 rounded-xl shadow-sm border border-gray-200 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 text-blue-700 rounded-full p-3 text-2xl">📋</div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Consultation Reports</h1>
                <p class="text-sm text-gray-500">
                    @if(Auth::user()->role === 'admin') All reports across the platform
                    @elseif(Auth::user()->role === 'doctor') Reports you have written
                    @else Your medical reports
                    @endif
                </p>
            </div>
        </div>
        <span class="bg-blue-50 text-blue-700 text-sm font-semibold px-4 py-2 rounded-full">
            {{ $reports->count() }} Report(s)
        </span>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 rounded-xl px-4 py-3 mb-4">{{ session('success') }}</div>
    @endif

    {{-- Reports Table --}}
    @if($reports->isEmpty())
        <div class="bg-white rounded-2xl shadow p-10 text-center">
            <p class="text-4xl mb-3">📭</p>
            <p class="text-gray-500 text-sm">No reports found.</p>
        </div>
    @else
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    @if(Auth::user()->role !== 'patient')
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                    @endif
                    @if(Auth::user()->role !== 'doctor')
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Doctor</th>
                    @endif
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Diagnosis</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($reports as $report)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400">#{{ $report->id }}</td>
                    @if(Auth::user()->role !== 'patient')
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $report->patient->name }}</td>
                    @endif
                    @if(Auth::user()->role !== 'doctor')
                    <td class="px-6 py-4 text-gray-600">Dr. {{ $report->doctor->name }}</td>
                    @endif
                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($report->appointment->appointment_date)->format('M j, Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ \Illuminate\Support\Str::limit($report->diagnosis, 40) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $report->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('reports.show', $report->id) }}" class="px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium hover:bg-blue-100">
                                View
                            </a>
                            @if(Auth::id() === $report->doctor_id)
                            <a href="{{ route('reports.edit', $report->id) }}" class="px-3 py-1 rounded-lg bg-gray-100 text-gray-600 text-xs font-medium hover:bg-gray-200">
                                Edit
                            </a>
                            @endif
                            <a href="{{ url('/reports/'.$report->id.'/pdf') }}" class="px-3 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-medium hover:bg-green-100">
                                PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
</body>
</html>
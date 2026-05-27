@extends('doctor.layout')

@section('content')

<style>
    .dashboard-title {
        margin-bottom: 20px;
    }

    .dashboard-title h1 {
        font-size: 28px;
        color: #0f172a;
    }

    .dashboard-title p {
        color: #64748b;
        margin-top: 5px;
    }

    .appointment-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-left: 6px solid #3b82f6;
        transition: 0.3s;
    }

    .appointment-card:hover {
        transform: translateY(-3px);
    }

    .appointment-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .patient-name {
        font-size: 20px;
        font-weight: 600;
        color: #0f172a;
    }

    .appointment-status {
        padding: 6px 14px;
        border-radius: 20px;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
    }

    .status-pending    { background: #f59e0b; }
    .status-approved   { background: #10b981; }
    .status-rejected   { background: #ef4444; }
    .status-rescheduled{ background: #3b82f6; }

    .appointment-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .detail-box {
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
    }

    .detail-title {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
    }

    .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    .approve        { background: #10b981; }
    .reject         { background: #ef4444; }
    .reschedule-btn { background: #3b82f6; }
    .approved-btn   { background: #10b981; }
    .rejected-btn   { background: #ef4444; }
    .view-btn       { background: #6366f1; }

    .reschedule-form {
        margin-top: 15px;
        display: none;
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
    }

    .reschedule-form input {
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .save-btn { background: #0f172a; }

    .empty-state {
        background: #fff;
        padding: 40px;
        text-align: center;
        border-radius: 14px;
        color: #64748b;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,0.6);
        backdrop-filter: blur(4px);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.active { display: flex; }

    .modal {
        background: white;
        border-radius: 24px;
        padding: 40px 36px;
        width: 420px;
        max-width: 95vw;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0,0,0,0.2);
        animation: popIn 0.3s ease;
        position: relative;
    }

    @keyframes popIn {
        from { transform: scale(0.9); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 14px;
        right: 18px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #94a3b8;
    }

    .modal-close:hover { color: #1e293b; }

    .modal-header { margin-bottom: 6px; }

    .modal-header h3 {
        font-size: 20px;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .modal-header p {
        font-size: 13px;
        color: #64748b;
    }

    .appt-meta {
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px 18px;
        margin: 18px 0;
        text-align: left;
        font-size: 13px;
        color: #475569;
        line-height: 1.8;
    }

    .appt-meta strong { color: #1e293b; }

    .reason-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 10px 14px;
        margin-top: 10px;
        text-align: left;
        font-size: 13px;
        color: #1e40af;
        line-height: 1.6;
    }

    .reason-box .reason-label {
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #3b82f6;
        margin-bottom: 4px;
        display: block;
    }

    .countdown-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .countdown-display {
        font-size: 48px;
        font-weight: 700;
        color: #2563eb;
        letter-spacing: 2px;
        font-variant-numeric: tabular-nums;
        margin-bottom: 8px;
    }

    .countdown-display.urgent {
        color: #ef4444;
        animation: pulse 1s infinite;
    }

    .countdown-display.expired {
        color: #94a3b8;
        font-size: 32px;
        animation: none;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.5; }
    }

    .countdown-sublabel {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 24px;
    }

    /* ✅ btn-start is now an <a> tag — styled to look like a button */
    .btn-start {
        display: none;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: white;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        animation: fadeIn 0.5s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-start:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22,163,74,0.35);
        color: white;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .status-badge {
        display: none;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
        animation: fadeIn 0.5s ease;
    }

    .status-badge.overdue {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .status-badge.expired {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
    }

    .waiting-msg {
        font-size: 13px;
        color: #94a3b8;
        margin-top: 6px;
    }

    @media(max-width: 768px) {
        .appointment-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .reschedule-form input {
            width: 100%;
        }
    }

    .report-btn      { background: #0ea5e9; }
    .view-report-btn { background: #8b5cf6; }
</style>

<div class="dashboard-title">
    <h1>Doctor Appointments</h1>
    <p>Manage patient appointments, approvals and rescheduling.</p>
</div>

@if($appointments->count() > 0)

    @foreach($appointments as $appointment)

        <div class="appointment-card">

            <div class="appointment-top">

                <div class="patient-name">
                    {{ $appointment->patient->name ?? 'Unknown Patient' }}
                </div>

                <div class="appointment-status
                    @if($appointment->status == 'approved') status-approved
                    @elseif($appointment->status == 'rejected') status-rejected
                    @elseif($appointment->status == 'rescheduled') status-rescheduled
                    @else status-pending
                    @endif
                ">
                    {{ ucfirst($appointment->status) }}
                </div>

            </div>

            <div class="appointment-details">

                <div class="detail-box">
                    <div class="detail-title">Description</div>
                    <div class="detail-value">
                        {{ $appointment->description ?? $appointment->reason ?? 'No description' }}
                    </div>
                </div>

                <div class="detail-box">
                    <div class="detail-title">Appointment Date</div>
                    <div class="detail-value">{{ $appointment->appointment_date }}</div>
                </div>

                <div class="detail-box">
                    <div class="detail-title">Appointment Time</div>
                    <div class="detail-value">{{ $appointment->appointment_time }}</div>
                </div>

            </div>

            <div class="actions">

                @if($appointment->status == 'approved')
                    <button class="btn approved-btn">Approved</button>
                @elseif($appointment->status == 'rejected')
                    <button class="btn rejected-btn">Rejected</button>
                @else
                    <form action="{{ route('appointment.approve', $appointment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn approve">Approve</button>
                    </form>

                    <form action="{{ route('appointment.reject', $appointment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn reject">Reject</button>
                    </form>
                @endif

                <button class="btn reschedule-btn" onclick="toggleForm({{ $appointment->id }})">
                    Reschedule
                </button>

                {{-- ✅ data-chat-url carries the correct patient ID for the chat route --}}
                <button
                    class="btn view-btn"
                    data-chat-url="{{ route('chat.show', $appointment->patient->id) }}"
                    onclick="openModal(
                        '{{ $appointment->id }}',
                        '{{ addslashes($appointment->doctor->name ?? 'N/A') }}',
                        '{{ addslashes($appointment->patient->name ?? 'Unknown Patient') }}',
                        '{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}',
                        '{{ addslashes($appointment->reason ?? $appointment->description ?? 'No reason provided') }}',
                        this
                    )">
                    <i class="fa-solid fa-eye" style="margin-right:6px;"></i>View
                </button>

                @if($appointment->status == 'approved')
                    @if($appointment->report)
                        <a href="{{ route('reports.show', $appointment->report->id) }}" class="btn" style="background:#8b5cf6; text-decoration:none;">
                            <i class="fa-solid fa-file-medical" style="margin-right:6px;"></i>View Report
                        </a>
                    @else
                        <a href="{{ route('reports.create', $appointment->id) }}" class="btn" style="background:#0ea5e9; text-decoration:none;">
                            <i class="fa-solid fa-file-pen" style="margin-right:6px;"></i>Write Report
                        </a>
                    @endif
                @endif

            </div>

            <form id="form-{{ $appointment->id }}"
                  class="reschedule-form"
                  action="{{ route('appointment.reschedule', $appointment->id) }}"
                  method="POST">
                @csrf
                <input type="date" name="appointment_date" value="{{ $appointment->appointment_date }}" required>
                <input type="time" name="appointment_time" value="{{ $appointment->appointment_time }}" required>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </form>

        </div>

    @endforeach

@else

    <div class="empty-state">
        <h2>No Appointments Yet</h2>
        <p>Patient appointments will appear here once booked.</p>
    </div>

@endif


{{-- ── MODAL HTML ── --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
       

        <button class="modal-close" onclick="closeModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-header">
            <h3><i class="fa-solid fa-stethoscope" style="color:#2563eb;margin-right:8px;"></i>Appointment Details</h3>
            <p>Session information</p>
        </div>

        <div class="appt-meta" id="modalMeta"></div>

        <div class="countdown-label">Time until appointment</div>
        <div class="countdown-display" id="countdownDisplay">--:--:--</div>
        <div class="countdown-sublabel" id="countdownSublabel">Calculating...</div>

        <div class="status-badge" id="statusBadge"></div>

        {{-- ✅ Now an <a> tag — href set dynamically in openModal() --}}
        <a class="btn-start" id="btnStart" href="#">
            <i class="fa-solid fa-video" style="margin-right:8px;"></i>Click to Start Session
        </a>
       

  

<style>
    .modal-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: none;
    background: #f1f5f9;
    color: #0f172a;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: 0.3s;
}



</style>

        <p class="waiting-msg" id="waitingMsg"></p>

    </div>
</div>


<script>
function toggleForm(id) {
    let form = document.getElementById('form-' + id);
    form.style.display = (form.style.display === 'block') ? 'none' : 'block';
}

let countdownInterval = null;

// ✅ Receives btnEl (this) instead of storing IDs in JS variables
function openModal(id, doctorName, patientName, isoTime, reason, btnEl) {

    // Grab the chat URL from the button's data attribute and set it on the link
    document.getElementById('btnStart').href = btnEl.dataset.chatUrl;

    isoTime = isoTime.replace(' ', 'T');

    document.getElementById('modalMeta').innerHTML = `
        <div><strong>Doctor:</strong> Dr. ${doctorName}</div>
        <div><strong>Patient:</strong> ${patientName}</div>
        <div><strong>Scheduled:</strong> ${formatDateTime(isoTime)}</div>
        <div class="reason-box">
            <span class="reason-label"><i class="fa-solid fa-notes-medical" style="margin-right:4px;"></i>Reason for Appointment</span>
            ${reason}
        </div>
    `;

    document.getElementById('modalOverlay').classList.add('active');
    startCountdown(isoTime);
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('active');

    if (countdownInterval) clearInterval(countdownInterval);

    const display = document.getElementById('countdownDisplay');
    display.textContent = '--:--:--';
    display.className   = 'countdown-display';

    document.getElementById('countdownSublabel').textContent = 'Calculating...';
    document.getElementById('btnStart').style.display        = 'none';
    document.getElementById('btnStart').href                 = '#'; // ✅ reset on close
    document.getElementById('waitingMsg').textContent        = '';

    const badge = document.getElementById('statusBadge');
    badge.style.display = 'none';
    badge.className     = 'status-badge';
    badge.textContent   = '';
}

function startCountdown(isoTime) {

    if (countdownInterval) clearInterval(countdownInterval);

    const appointmentTime = new Date(isoTime).getTime();

    function tick() {

        const now  = Date.now();
        const diff = appointmentTime - now;

        const display    = document.getElementById('countdownDisplay');
        const sublabel   = document.getElementById('countdownSublabel');
        const btnStart   = document.getElementById('btnStart');
        const waitingMsg = document.getElementById('waitingMsg');
        const badge      = document.getElementById('statusBadge');

        if (diff <= 0) {

            clearInterval(countdownInterval);

            const overdueMs      = Math.abs(diff);
            const overdueMinutes = Math.floor(overdueMs / (1000 * 60));
            const overdueDays    = Math.floor(overdueMs / (1000 * 60 * 60 * 24));

            if (overdueDays >= 1) {
                display.textContent     = 'EXPIRED';
                display.className       = 'countdown-display expired';
                sublabel.textContent    = `Appointment was ${overdueDays} day(s) ago`;
                badge.innerHTML         = '<i class="fa-solid fa-ban" style="margin-right:6px;"></i>Session Expired — This appointment can no longer be started';
                badge.className         = 'status-badge expired';
                badge.style.display     = 'block';
                btnStart.style.display  = 'none';
                waitingMsg.textContent  = '';

            } else if (overdueMinutes > 30) {
                display.textContent     = 'OVERDUE';
                display.className       = 'countdown-display urgent';
                sublabel.textContent    = `${overdueMinutes} minutes past appointment time`;
                badge.innerHTML         = '<i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>Session Overdue — Please reschedule';
                badge.className         = 'status-badge overdue';
                badge.style.display     = 'block';
                btnStart.style.display  = 'none';
                waitingMsg.textContent  = '';

            } else {
                display.textContent     = '00:00:00';
                display.className       = 'countdown-display urgent';
                sublabel.textContent    = "It's time for the appointment!";
                badge.style.display     = 'none';
                btnStart.style.display  = 'block';
                waitingMsg.textContent  = '';
            }

            return;
        }

        const hours   = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        display.textContent =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

        badge.style.display    = 'none';
        btnStart.style.display = 'none';

        if (diff < 5 * 60 * 1000) {
            display.className    = 'countdown-display urgent';
            sublabel.textContent = 'Almost time — get ready!';
        } else if (diff < 60 * 60 * 1000) {
            display.className    = 'countdown-display';
            sublabel.textContent = 'Less than an hour to go';
        } else {
            display.className    = 'countdown-display';
            sublabel.textContent = 'Hours : Minutes : Seconds';
        }
    }

    tick();
    countdownInterval = setInterval(tick, 1000);
}

function formatDateTime(isoString) {
    const d = new Date(isoString);
    return d.toLocaleDateString('en-GB', {
        day: '2-digit', month: 'short', year: 'numeric'
    }) + ' at ' + d.toLocaleTimeString('en-GB', {
        hour: '2-digit', minute: '2-digit'
    });
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

@endsection
@extends('doctor.layout')

@section('content')

<style>
    /* ── Page header ── */
    .page-header { margin-bottom: 24px; }
    .page-header h1 { font-size: 24px; font-weight: 700; color: #0f172a; }
    .page-header p  { color: #64748b; margin-top: 4px; font-size: 14px; }

    /* ── Appointment card ── */
    .appt-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 16px;
        border: 1px solid #e2e8f0;
        border-left: 5px solid #3b82f6;
        transition: box-shadow .2s, transform .2s;
    }
    .appt-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.07);
        transform: translateY(-2px);
    }

    /* ── Card top row ── */
    .card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .patient-name {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .patient-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 700;
        flex-shrink: 0;
    }

    /* ── Status badge ── */
    .status-badge {
        padding: 5px 13px;
        border-radius: 20px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .s-pending    { background: #f59e0b; }
    .s-approved   { background: #10b981; }
    .s-rejected   { background: #ef4444; }
    .s-rescheduled{ background: #3b82f6; }

    /* ── Detail grid ── */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .detail-box {
        background: #f8fafc;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
    }

    .detail-label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; margin-bottom: 4px; font-weight: 600; }
    .detail-val   { font-size: 14px; font-weight: 600; color: #0f172a; }

    /* ── Actions ── */
    .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        border-radius: 8px;
        border: none;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: opacity .15s, transform .15s;
        -webkit-tap-highlight-color: transparent;
        white-space: nowrap;
    }
    .btn:hover   { opacity: .88; }
    .btn:active  { transform: scale(.97); }

    .btn-approve   { background: #10b981; }
    .btn-reject    { background: #ef4444; }
    .btn-reschedule{ background: #3b82f6; }
    .btn-view      { background: #6366f1; }
    .btn-report    { background: #0ea5e9; }
    .btn-vreport   { background: #8b5cf6; }
    .btn-done      { background: #94a3b8; cursor: default; }

    /* ── Reschedule form ── */
    .reschedule-form {
        display: none;
        margin-top: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .reschedule-form.open { display: flex; }

    .reschedule-form label {
        font-size: 12px; font-weight: 600;
        color: #64748b; display: block; margin-bottom: 4px;
    }

    .reschedule-form input {
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: #0f172a;
        background: #fff;
        width: 100%;
    }

    .rform-field { flex: 1; min-width: 140px; }

    .btn-save { background: #0f172a; }

    /* ── Empty state ── */
    .empty-state {
        background: #fff;
        padding: 48px 24px;
        text-align: center;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        color: #64748b;
    }
    .empty-state i  { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block; }
    .empty-state h2 { font-size: 18px; color: #0f172a; margin-bottom: 6px; }
    .empty-state p  { font-size: 14px; }

    /* ── MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(15,23,42,.65);
        backdrop-filter: blur(4px);
        z-index: 999;
        justify-content: center;
        align-items: center;
        padding: 16px;
    }
    .modal-overlay.active { display: flex; }

    .modal {
        background: #fff;
        border-radius: 20px;
        padding: 32px 28px;
        width: 100%;
        max-width: 440px;
        max-height: calc(100dvh - 32px);
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        animation: popIn .25s ease;
    }

    @keyframes popIn {
        from { transform: scale(.93); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 14px; right: 14px;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #f1f5f9;
        border: none;
        color: #0f172a;
        font-size: 16px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
        -webkit-tap-highlight-color: transparent;
    }
    .modal-close:hover { background: #e2e8f0; }

    .modal-title {
        font-size: 18px; font-weight: 700; color: #0f172a;
        margin-bottom: 4px;
        display: flex; align-items: center; gap: 8px;
    }

    .modal-subtitle { font-size: 13px; color: #64748b; margin-bottom: 18px; }

    .modal-meta {
        background: #f8fafc;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 18px;
        font-size: 13px;
        color: #475569;
        line-height: 1.9;
    }
    .modal-meta strong { color: #0f172a; }

    .reason-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 10px 14px;
        margin-top: 10px;
        font-size: 13px;
        color: #1e40af;
        line-height: 1.6;
    }
    .reason-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #3b82f6; margin-bottom: 4px; display: block; }

    .countdown-section { text-align: center; margin-bottom: 18px; }
    .countdown-label-text { font-size: 12px; color: #64748b; margin-bottom: 6px; font-weight: 500; }
    .countdown-display {
        font-size: 44px; font-weight: 700; color: #2563eb;
        letter-spacing: 2px; font-variant-numeric: tabular-nums;
        margin-bottom: 4px;
    }
    .countdown-display.urgent   { color: #ef4444; animation: blink 1s infinite; }
    .countdown-display.expired  { color: #94a3b8; font-size: 28px; animation: none; }
    @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:.4;} }

    .countdown-sub { font-size: 12px; color: #94a3b8; margin-bottom: 16px; }

    .modal-status-badge {
        display: none;
        padding: 10px 14px; border-radius: 10px;
        font-size: 13px; font-weight: 600; margin-bottom: 12px;
        text-align: center;
    }
    .modal-status-badge.overdue { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
    .modal-status-badge.expired { background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; }

    .btn-start {
        display: none;
        width: 100%; padding: 14px;
        background: #16a34a; color: #fff;
        border-radius: 12px; border: none;
        font-size: 15px; font-weight: 700;
        cursor: pointer; text-decoration: none;
        text-align: center; transition: opacity .15s, transform .15s;
        -webkit-tap-highlight-color: transparent;
    }
    .btn-start:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

    /* ── Mobile overrides ── */
    @media (max-width: 640px) {
        .card-top { flex-direction: column; align-items: stretch; }
        .card-top .status-badge { align-self: flex-start; }
        .actions { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
        .detail-grid { grid-template-columns: 1fr; }
        .modal { padding: 24px 18px; }
        .countdown-display { font-size: 36px; }
    }
</style>

<div class="page-header">
    <h1><i class="fa-solid fa-calendar-check" style="color:#3b82f6;margin-right:8px;"></i>Appointments</h1>
    <p>Manage patient appointments, approvals and rescheduling.</p>
</div>

@if($appointments->count() > 0)

    @foreach($appointments as $appointment)
    <div class="appt-card">

        <div class="card-top">
            <div class="patient-name">
                <div class="patient-avatar">
                    {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 1)) }}
                </div>
                {{ $appointment->patient->name ?? 'Unknown Patient' }}
            </div>
            <span class="status-badge
                @if($appointment->status == 'approved') s-approved
                @elseif($appointment->status == 'rejected') s-rejected
                @elseif($appointment->status == 'rescheduled') s-rescheduled
                @else s-pending @endif
            ">{{ ucfirst($appointment->status) }}</span>
        </div>

        <div class="detail-grid">
            <div class="detail-box">
                <div class="detail-label"><i class="fa-solid fa-file-lines" style="margin-right:4px;"></i>Description</div>
                <div class="detail-val">{{ $appointment->description ?? $appointment->reason ?? 'No description' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><i class="fa-regular fa-calendar" style="margin-right:4px;"></i>Date</div>
                <div class="detail-val">{{ $appointment->appointment_date }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><i class="fa-regular fa-clock" style="margin-right:4px;"></i>Time</div>
                <div class="detail-val">{{ $appointment->appointment_time }}</div>
            </div>
        </div>

        <div class="actions">
            @if($appointment->status == 'approved')
                <button class="btn btn-done" disabled>
                    <i class="fa-solid fa-circle-check"></i> Approved
                </button>
            @elseif($appointment->status == 'rejected')
                <button class="btn btn-done" disabled>
                    <i class="fa-solid fa-circle-xmark"></i> Rejected
                </button>
            @else
                <form action="{{ route('appointment.approve', $appointment->id) }}" method="POST" style="display:contents;">
                    @csrf
                    <button type="submit" class="btn btn-approve">
                        <i class="fa-solid fa-check"></i> Approve
                    </button>
                </form>
                <form action="{{ route('appointment.reject', $appointment->id) }}" method="POST" style="display:contents;">
                    @csrf
                    <button type="submit" class="btn btn-reject">
                        <i class="fa-solid fa-xmark"></i> Reject
                    </button>
                </form>
            @endif

            <button class="btn btn-reschedule" onclick="toggleForm({{ $appointment->id }})">
                <i class="fa-regular fa-calendar-days"></i> Reschedule
            </button>

            <button class="btn btn-view"
                data-chat-url="{{ route('chat.show', $appointment->patient->id) }}"
                onclick="openModal(
                    '{{ $appointment->id }}',
                    '{{ addslashes($appointment->doctor->name ?? 'N/A') }}',
                    '{{ addslashes($appointment->patient->name ?? 'Unknown Patient') }}',
                    '{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}',
                    '{{ addslashes($appointment->reason ?? $appointment->description ?? 'No reason provided') }}',
                    this
                )">
                <i class="fa-solid fa-eye"></i> View
            </button>

            @if($appointment->status == 'approved')
                @if($appointment->report)
                    <a href="{{ route('reports.show', $appointment->report->id) }}" class="btn btn-vreport">
                        <i class="fa-solid fa-file-medical"></i> View Report
                    </a>
                @else
                    <a href="{{ route('reports.create', $appointment->id) }}" class="btn btn-report">
                        <i class="fa-solid fa-file-pen"></i> Write Report
                    </a>
                @endif
            @endif
        </div>

        <form id="form-{{ $appointment->id }}"
              class="reschedule-form"
              action="{{ route('appointment.reschedule', $appointment->id) }}"
              method="POST">
            @csrf
            <div class="rform-field">
                <label>New Date</label>
                <input type="date" name="appointment_date" value="{{ $appointment->appointment_date }}" required>
            </div>
            <div class="rform-field">
                <label>New Time</label>
                <input type="time" name="appointment_time" value="{{ $appointment->appointment_time }}" required>
            </div>
            <button type="submit" class="btn btn-save">
                <i class="fa-solid fa-floppy-disk"></i> Save
            </button>
        </form>

    </div>
    @endforeach

@else
    <div class="empty-state">
        <i class="fa-regular fa-calendar-xmark"></i>
        <h2>No Appointments Yet</h2>
        <p>Patient appointments will appear here once booked.</p>
    </div>
@endif


<!-- ── MODAL ── -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">

        <button class="modal-close" onclick="closeModal()" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-title">
            <i class="fa-solid fa-stethoscope" style="color:#2563eb;font-size:18px;"></i>
            Appointment Details
        </div>
        <div class="modal-subtitle">Session information</div>

        <div class="modal-meta" id="modalMeta"></div>

        <div class="countdown-section">
            <div class="countdown-label-text">Time until appointment</div>
            <div class="countdown-display" id="countdownDisplay">--:--:--</div>
            <div class="countdown-sub" id="countdownSub">Calculating...</div>
        </div>

        <div class="modal-status-badge" id="statusBadge"></div>

        <a class="btn-start" id="btnStart" href="#">
            <i class="fa-solid fa-video" style="margin-right:8px;"></i>Start Session
        </a>

    </div>
</div>


<script>
function toggleForm(id) {
    const f = document.getElementById('form-' + id);
    f.classList.toggle('open');
}

let countdownInterval = null;

function openModal(id, doctorName, patientName, isoTime, reason, btnEl) {
    document.getElementById('btnStart').href = btnEl.dataset.chatUrl;
    isoTime = isoTime.replace(' ', 'T');
    const initials = patientName.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);
    document.getElementById('modalMeta').innerHTML = `
        <div><strong>Doctor:</strong> Dr. ${doctorName}</div>
        <div><strong>Patient:</strong> ${patientName}</div>
        <div><strong>Scheduled:</strong> ${formatDateTime(isoTime)}</div>
        <div class="reason-box">
            <span class="reason-label"><i class="fa-solid fa-notes-medical" style="margin-right:4px;"></i>Reason</span>
            ${reason}
        </div>`;
    document.getElementById('modalOverlay').classList.add('active');
    startCountdown(isoTime);
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('active');
    if (countdownInterval) clearInterval(countdownInterval);
    const disp = document.getElementById('countdownDisplay');
    disp.textContent = '--:--:--';
    disp.className   = 'countdown-display';
    document.getElementById('countdownSub').textContent   = 'Calculating...';
    document.getElementById('btnStart').style.display     = 'none';
    document.getElementById('btnStart').href              = '#';
    const badge = document.getElementById('statusBadge');
    badge.style.display = 'none';
    badge.className     = 'modal-status-badge';
    badge.textContent   = '';
}

function startCountdown(isoTime) {
    if (countdownInterval) clearInterval(countdownInterval);
    const apptTime = new Date(isoTime).getTime();
    function tick() {
        const now  = Date.now();
        const diff = apptTime - now;
        const disp    = document.getElementById('countdownDisplay');
        const sub     = document.getElementById('countdownSub');
        const btn     = document.getElementById('btnStart');
        const badge   = document.getElementById('statusBadge');
        if (diff <= 0) {
            clearInterval(countdownInterval);
            const overMin  = Math.floor(Math.abs(diff) / 60000);
            const overDays = Math.floor(Math.abs(diff) / 86400000);
            if (overDays >= 1) {
                disp.textContent = 'EXPIRED'; disp.className = 'countdown-display expired';
                sub.textContent  = `${overDays} day(s) ago`;
                badge.innerHTML  = '<i class="fa-solid fa-ban" style="margin-right:6px;"></i>Session expired — cannot be started';
                badge.className  = 'modal-status-badge expired'; badge.style.display = 'block';
                btn.style.display = 'none';
            } else if (overMin > 30) {
                disp.textContent = 'OVERDUE'; disp.className = 'countdown-display urgent';
                sub.textContent  = `${overMin} minutes past appointment time`;
                badge.innerHTML  = '<i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>Session overdue — please reschedule';
                badge.className  = 'modal-status-badge overdue'; badge.style.display = 'block';
                btn.style.display = 'none';
            } else {
                disp.textContent = '00:00:00'; disp.className = 'countdown-display urgent';
                sub.textContent  = "It's time for the appointment!";
                badge.style.display = 'none'; btn.style.display = 'block';
            }
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        disp.textContent = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        badge.style.display = 'none'; btn.style.display = 'none';
        if (diff < 300000)     { disp.className = 'countdown-display urgent'; sub.textContent = 'Almost time — get ready!'; }
        else if (diff < 3600000){ disp.className = 'countdown-display'; sub.textContent = 'Less than an hour to go'; }
        else                    { disp.className = 'countdown-display'; sub.textContent = 'Hours : Minutes : Seconds'; }
    }
    tick();
    countdownInterval = setInterval(tick, 1000);
}

function formatDateTime(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'})
         + ' at ' + d.toLocaleTimeString('en-GB', {hour:'2-digit', minute:'2-digit'});
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

@endsection
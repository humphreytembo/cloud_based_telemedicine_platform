<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointments</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #1e293b;
        }

        .card {
            background: white;
            padding: 20px 24px;
            margin-bottom: 12px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-info strong { color: #1e293b; }

        .card-info p {
            font-size: 14px;
            color: #475569;
            margin-top: 4px;
        }

        .badge {
            padding: 5px 12px;
            background: #dbeafe;
            color: #2563eb;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-view {
            background: #2563eb;
            color: white;
            border: none;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-view:hover { background: #1d4ed8; }

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

        .modal-wrapper { position: relative; }
    </style>
</head>

<body>

<h2><i class="fa-solid fa-calendar-check" style="color:#2563eb;margin-right:8px;"></i>My Appointments</h2>

@forelse($appointments as $appointment)

<div class="card">

    <div class="card-info">
        <strong>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</strong>
        <p>
            <i class="fa-solid fa-user" style="margin-right:4px;"></i>
            Patient: {{ $appointment->patient->name ?? 'N/A' }}
        </p>
        <p>
            <i class="fa-regular fa-clock" style="margin-right:4px;"></i>
            {{ \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time)->format('d M Y \a\t H:i') }}
        </p>
        @if($appointment->reason)
        <p>
            <i class="fa-solid fa-notes-medical" style="margin-right:4px;color:#3b82f6;"></i>
            <span style="color:#1e40af;font-weight:500;">{{ $appointment->reason }}</span>
        </p>
        @endif
    </div>

    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <span class="badge">
            {{ ucfirst($appointment->status ?? 'scheduled') }}
        </span>

        {{-- ✅ data-chat-url carries the correct Laravel-generated URL --}}
        <button
            class="btn-view"
            data-chat-url="{{ route('chat.show', $appointment->doctor->id) }}"
            onclick="openModal(
                '{{ $appointment->id }}',
                '{{ addslashes($appointment->doctor->name ?? 'N/A') }}',
                '{{ addslashes($appointment->patient->name ?? 'N/A') }}',
                '{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}',
                '{{ addslashes($appointment->reason ?? 'No reason provided') }}',
                this
            )">
            <i class="fa-solid fa-eye" style="margin-right:6px;"></i>View
        </button>

        @if($appointment->report && $appointment->report->status === 'published')
            <a href="{{ route('reports.show', $appointment->report->id) }}"
               style="background:#8b5cf6;color:white;border:none;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:0.2s;text-decoration:none;">
                <i class="fa-solid fa-file-medical" style="margin-right:6px;"></i>View Report
            </a>
        @endif

        @if($appointment->report)
            <a href="{{ route('reports.show', $appointment->report->id) }}#vitals"
               style="background:#0ea5e9;color:white;border:none;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:0.2s;text-decoration:none;">
                <i class="fa-solid fa-heart-pulse" style="margin-right:6px;"></i>My Vitals
            </a>
        @endif

    </div>

</div>

@empty
    <div class="card" style="color:#94a3b8;text-align:center;">
        No appointments found.
    </div>
@endforelse


{{-- ── MODAL ── --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="modal modal-wrapper">

        <button class="modal-close" onclick="closeModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-header">
            <h3><i class="fa-solid fa-stethoscope" style="color:#2563eb;margin-right:8px;"></i>Appointment Details</h3>
            <p>Your session information</p>
        </div>

        <div class="appt-meta" id="modalMeta"></div>

        <div class="countdown-label">Time until your appointment</div>

        <div class="countdown-display" id="countdownDisplay">--:--:--</div>
        <div class="countdown-sublabel" id="countdownSublabel">Calculating...</div>

        <div class="status-badge" id="statusBadge"></div>

        {{-- ✅ Now an <a> tag — href is set dynamically in openModal() --}}
        <a class="btn-start" id="btnStart" href="#">
            <i class="fa-solid fa-video" style="margin-right:8px;"></i>Click to Start Session
        </a>

        <p class="waiting-msg" id="waitingMsg"></p>

    </div>
</div>


<script>
    let countdownInterval = null;

    // ✅ Receives the button element (this) instead of doctorId as a string
    function openModal(id, doctorName, patientName, isoTime, reason, btnEl) {

        // Grab the chat URL from the button's data attribute
        const chatUrl = btnEl.dataset.chatUrl;

        // Set it directly on the Start Session link
        document.getElementById('btnStart').href = chatUrl;

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
        document.getElementById('btnStart').href                 = '#'; // ✅ reset href on close
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
                    badge.innerHTML         = '<i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>Session Overdue — Please reschedule with your doctor';
                    badge.className         = 'status-badge overdue';
                    badge.style.display     = 'block';
                    btnStart.style.display  = 'none';
                    waitingMsg.textContent  = '';

                } else {
                    display.textContent     = '00:00:00';
                    display.className       = 'countdown-display urgent';
                    sublabel.textContent    = "It's time for your appointment!";
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

</body>
</html>
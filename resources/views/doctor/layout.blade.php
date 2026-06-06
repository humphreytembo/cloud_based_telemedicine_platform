<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        :root {
            --sidebar-w: 250px;
            --topbar-h:  64px;
            --bg:        #f4f7fb;
            --surface:   #ffffff;
            --nav-bg:    #0f172a;
            --nav-hover: #1e293b;
            --nav-text:  #cbd5e1;
            --accent:    #3b82f6;
            --text:      #0f172a;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --radius:    10px;
        }

        html, body {
            height: 100%;
            background: var(--bg);
            -webkit-text-size-adjust: 100%;
        }

        /* ── LAYOUT ── */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--nav-bg);
            color: #fff;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 300;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 18px 18px;
            border-bottom: 1px solid #1e293b;
            flex-shrink: 0;
        }

        .sidebar-logo h2 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
        }

        /* Close button — only visible on mobile */
        .sidebar-close {
            display: none;
            width: 34px; height: 34px;
            border-radius: 8px;
            background: rgba(255,255,255,.08);
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: background .15s;
            -webkit-tap-highlight-color: transparent;
            flex-shrink: 0;
        }

        .sidebar-close:hover { background: rgba(255,255,255,.16); }

        .sidebar nav {
            flex: 1;
            padding: 10px 0;
        }

        .sidebar nav a,
        .sidebar nav .nav-form button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 13px 20px;
            color: var(--nav-text);
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s, border-color .15s;
            -webkit-tap-highlight-color: transparent;
        }

        .sidebar nav a:hover,
        .sidebar nav .nav-form button:hover {
            background: var(--nav-hover);
            color: #fff;
        }

        .sidebar nav a.active {
            background: var(--nav-hover);
            color: #fff;
            border-left-color: var(--accent);
        }

        .sidebar nav a i,
        .sidebar nav .nav-form button i {
            font-size: 16px;
            width: 18px;
            flex-shrink: 0;
        }

        .nav-form { width: 100%; }

        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            line-height: 1.4;
        }

        /* ── BACKDROP (mobile) ── */
        .sidebar-backdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 290;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        .sidebar-backdrop.active { display: block; }

        /* ── MAIN ── */
        .main {
            flex: 1;
            margin-left: var(--sidebar-w);
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
            padding: 0 20px;
            height: var(--topbar-h);
            border-bottom: 1px solid var(--border);
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .menu-btn {
            display: none;
            width: 40px; height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
            font-size: 18px;
            cursor: pointer;
            align-items: center; justify-content: center;
            transition: background .15s;
            -webkit-tap-highlight-color: transparent;
        }
        .menu-btn:hover { background: var(--border); }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .welcome-pill {
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            flex: 1;
            padding: 24px 20px;
        }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 8px 0 32px rgba(0,0,0,.3);
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-close { display: flex; }

            .main { margin-left: 0; }

            .menu-btn { display: flex; }

            .welcome-pill {
                font-size: 12px;
                padding: 5px 10px;
                max-width: 160px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .page-content { padding: 16px 14px; }
        }

        @media (max-width: 380px) {
            .welcome-pill { display: none; }
        }
    </style>
</head>

<body>

<div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

<div class="app-wrapper">

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-logo">
            <h2><i class="fa-solid fa-stethoscope" style="color:#3b82f6;margin-right:8px;"></i>Doctor</h2>
            <button class="sidebar-close" id="sidebarClose" onclick="closeSidebar()" aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav>
            <a href="{{ route('doctor.dashboard') }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            <a href="{{ url('/doctor/messages') }}">
                <i class="fa-solid fa-comments"></i> Messages
                @if(isset($unreadMessages) && $unreadMessages > 0)
                    <span class="nav-badge">{{ $unreadMessages }}</span>
                @endif
            </a>

            <a href="{{ route('reports.index') }}">
                <i class="fa-solid fa-file-medical"></i> Reports
            </a>

            <div class="nav-form">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

    </aside>

    <!-- ── MAIN ── -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" onclick="openSidebar()" aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <span class="topbar-title">
                    <i class="fa-solid fa-stethoscope" style="color:#3b82f6;margin-right:6px;font-size:14px;"></i>Doctor Panel
                </span>
            </div>
            <div class="topbar-right">
                <span class="welcome-pill">
                    <i class="fa-solid fa-circle-user" style="margin-right:5px;"></i>Dr. {{ auth()->user()->name }}
                </span>
            </div>
        </div>

        <!-- Page content -->
        <div class="page-content">
            @yield('content')
        </div>

    </div>

</div><!-- /app-wrapper -->


<!-- ── SESSION WARNING MODAL ── -->
<div id="sessionModal" style="
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,0.6); z-index:9999;
    justify-content:center; align-items:center;
    padding:16px;
">
    <div style="
        background:#fff; width:100%; max-width:380px;
        padding:32px 28px; border-radius:16px;
        text-align:center; box-shadow:0 16px 40px rgba(0,0,0,.2);
    ">
        <div style="width:52px;height:52px;border-radius:50%;background:#fff7ed;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="fa-solid fa-clock" style="color:#f59e0b;font-size:22px;"></i>
        </div>
        <h2 style="color:#0f172a;margin-bottom:10px;font-size:18px;">Session Expiring</h2>
        <p style="color:#64748b;margin-bottom:16px;font-size:14px;line-height:1.6;">
            You'll be logged out due to inactivity.
        </p>
        <div id="countdown" style="font-size:52px;font-weight:700;color:#ef4444;margin-bottom:8px;font-variant-numeric:tabular-nums;">60</div>
        <p style="color:#94a3b8;font-size:12px;margin-bottom:20px;">seconds remaining</p>
        <button onclick="stayLoggedIn()" style="
            background:#3b82f6; color:#fff; border:none;
            padding:13px 24px; border-radius:10px; cursor:pointer;
            font-weight:700; font-size:14px; width:100%;
        ">
            <i class="fa-solid fa-rotate-right" style="margin-right:6px;"></i>Stay Logged In
        </button>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

<script>
/* ── Sidebar ── */
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarBackdrop').classList.remove('active');
    document.body.style.overflow = '';
}

/* Swipe left to close */
(function(){
    let sx = 0;
    const s = document.getElementById('sidebar');
    s.addEventListener('touchstart', e => { sx = e.touches[0].clientX; }, { passive:true });
    s.addEventListener('touchend',   e => { if (sx - e.changedTouches[0].clientX > 55) closeSidebar(); }, { passive:true });
})();

/* Close when nav link tapped on mobile */
document.querySelectorAll('.sidebar nav a').forEach(a => {
    a.addEventListener('click', () => {
        if (window.innerWidth <= 768) closeSidebar();
    });
});

/* ── Session timer ── */
const inactivityTime = 5 * 60 * 1000;
const warningTime    = 60 * 1000;
let logoutTimer, warningTimer, countdownInterval, countdown = 60;

function resetTimers() {
    clearTimeout(logoutTimer);
    clearTimeout(warningTimer);
    clearInterval(countdownInterval);
    document.getElementById('sessionModal').style.display = 'none';
    countdown = 60;
    warningTimer = setTimeout(showWarning, inactivityTime - warningTime);
    logoutTimer  = setTimeout(logoutUser,  inactivityTime);
}

function showWarning() {
    document.getElementById('sessionModal').style.display = 'flex';
    document.getElementById('countdown').innerText = countdown;
    countdownInterval = setInterval(() => {
        countdown--;
        document.getElementById('countdown').innerText = countdown;
        if (countdown <= 0) clearInterval(countdownInterval);
    }, 1000);
}

function logoutUser()   { document.getElementById('logout-form').submit(); }
function stayLoggedIn() { resetTimers(); }

window.onload        = resetTimers;
document.onmousemove = resetTimers;
document.onkeypress  = resetTimers;
document.onclick     = resetTimers;
document.onscroll    = resetTimers;
document.ontouchstart = resetTimers;
</script>

</body>
</html>
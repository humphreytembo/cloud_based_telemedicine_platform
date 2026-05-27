<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            display: flex;
            background: #f4f7fb;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #0f172a;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            transition: 0.3s;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar a, .sidebar button {
            display: block;
            width: 100%;
            padding: 15px 25px;
            color: #cbd5e1;
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .sidebar a:hover, .sidebar button:hover {
            background: #1e293b;
            color: #fff;
        }

        .main {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .toggle-btn {
            cursor: pointer;
            font-size: 22px;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .main {
                margin-left: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="sidebar" id="sidebar">
    <h2>🩺 Doctor</h2>

    <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
    
   

    <a href="/doctor/messages">
        Messages
        @if(isset($unreadMessages) && $unreadMessages > 0)
            <span style="background:red;color:white;padding:2px 8px;border-radius:50%;font-size:12px;margin-left:10px;">
                {{ $unreadMessages }}
            </span>
        @endif
    </a>

    {{-- ✅ FIXED: was $appointment->report->id which broke every page --}}
    <a href="{{ route('reports.index') }}">Reports</a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

<div class="main">

    <div class="topbar">
        <div class="toggle-btn" onclick="toggleSidebar()">☰</div>
        <div>Welcome, Dr. {{ auth()->user()->name }}</div>
    </div>

    @yield('content')

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}
</script>

</body>

<!-- SESSION WARNING MODAL -->
<div id="sessionModal" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:9999;
    justify-content:center;
    align-items:center;
">
    <div style="
        background:white;
        width:400px;
        padding:30px;
        border-radius:15px;
        text-align:center;
        box-shadow:0 10px 30px rgba(0,0,0,0.2);
    ">
        <h2 style="color:#0f172a;margin-bottom:15px;">Session Expiring</h2>
        <p style="color:#64748b;margin-bottom:20px;">
            For security reasons, you will be logged out due to inactivity.
        </p>
        <h1 id="countdown" style="font-size:50px;color:#ef4444;margin-bottom:20px;">60</h1>
        <button onclick="stayLoggedIn()" style="
            background:#3b82f6;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
        ">
            Stay Logged In
        </button>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<script>
    const inactivityTime = 5 * 60 * 1000;
    const warningTime    = 60 * 1000;

    let logoutTimer;
    let warningTimer;
    let countdownInterval;
    let countdown = 60;

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

    function logoutUser()    { document.getElementById('logout-form').submit(); }
    function stayLoggedIn()  { resetTimers(); }

    window.onload        = resetTimers;
    document.onmousemove = resetTimers;
    document.onkeypress  = resetTimers;
    document.onclick     = resetTimers;
    document.onscroll    = resetTimers;
</script>

</html>
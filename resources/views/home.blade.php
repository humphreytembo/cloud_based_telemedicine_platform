<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f1f5f9;
    color:#1e293b;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    background:linear-gradient(to bottom,#0f172a,#1e293b);
    color:#fff;
    padding-top:20px;
    z-index:1000;
    transition:0.3s;
    overflow-y:auto;
}

.logo{
    text-align:center;
    padding:10px 20px 30px;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

.logo h2{
    font-size:24px;
    color:#38bdf8;
}

.logo p{
    font-size:13px;
    color:#94a3b8;
    margin-top:5px;
}

.sidebar-links{
    margin-top:20px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:14px;
    color:#cbd5e1;
    text-decoration:none;
    padding:15px 25px;
    margin:5px 12px;
    border-radius:12px;
    transition:0.3s;
    font-size:15px;
}

.sidebar a:hover,
.sidebar a.active{
    background:#0ea5e9;
    color:#fff;
    transform:translateX(5px);
}

.sidebar a i{
    font-size:18px;
}

/* MAIN CONTENT */
.main{
    margin-left:260px;
    padding:25px;
    transition:0.3s;
}

/* TOPBAR */
.topbar{
    background:white;
    border-radius:18px;
    padding:18px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

.top-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.menu-toggle{
    display:none;
    font-size:24px;
    cursor:pointer;
}

.welcome h1{
    font-size:28px;
    color:#0f172a;
}

.welcome p{
    color:#64748b;
    margin-top:5px;
}

.logout{
    background:#ef4444;
    border:none;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
    font-weight:600;
}

.logout:hover{
    background:#dc2626;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    margin-top:30px;
}

.stat-card{
    background:white;
    padding:25px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    position:relative;
    overflow:hidden;
    transition:0.3s;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.stat-card i{
    font-size:32px;
    margin-bottom:15px;
    color:#0ea5e9;
}

.stat-card h3{
    font-size:30px;
    margin-bottom:8px;
}

.stat-card p{
    color:#64748b;
    font-size:15px;
}

/* ACTION CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-top:30px;
}

.card{
    background:white;
    border-radius:20px;
    padding:30px 25px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    transition:0.3s;
    position:relative;
}

.card:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.card i{
    font-size:45px;
    margin-bottom:18px;
    color:#0ea5e9;
}

.card h3{
    margin-bottom:10px;
    font-size:20px;
}

.card p{
    color:#64748b;
    font-size:14px;
    margin-bottom:20px;
}

.card a{
    text-decoration:none;
    background:#0ea5e9;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    display:inline-block;
    transition:0.3s;
    font-weight:600;
}

.card a:hover{
    background:#0284c7;
}

/* SECTIONS */
.section{
    margin-top:35px;
}

.section-title{
    margin-bottom:18px;
    font-size:24px;
    color:#0f172a;
}

.box{
    background:white;
    padding:20px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:15px;
}

.box p{
    color:#64748b;
    margin-top:5px;
}

/* APPOINTMENT STYLE */
.appointment{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
}

.badge{
    background:#dcfce7;
    color:#166534;
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

/* MOBILE */
@media(max-width:768px){

    .sidebar{
        left:-260px;
    }

    .sidebar.active{
        left:0;
    }

    .main{
        margin-left:0;
        padding:15px;
    }

    .menu-toggle{
        display:block;
    }

    .topbar{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .welcome h1{
        font-size:22px;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <div class="logo">
        <h2>MediCare+</h2>
        <p>Cloud Telemedicine Platform</p>
    </div>

    <div class="sidebar-links">
        <a href="{{ url('patient/dashboard') }}" class="active">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="{{ url('appointments') }}">
            <i class="fa-solid fa-calendar-check"></i>
            Appointments
        </a>

        <a href="{{ url('doctors/consult') }}">
            <i class="fa-solid fa-user-doctor"></i>
            Doctors
        </a>

        <a href="{{ url('dr-ai-chat') }}">
            <i class="fa-solid fa-robot"></i>
            Dr AI Assistant
        </a>

        <a href="{{ url('patient/profile') }}">
            <i class="fa-solid fa-user"></i>
            Profile
        </a>
    </div>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="top-left">

            <span class="menu-toggle" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i>
            </span>

            <div class="welcome">
                <h1>Welcome, {{ Auth::user()->name }} 👋</h1>
                <p>Your health dashboard is ready.</p>
            </div>

        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>
        </form>

    </div>

    <!-- ACTION CARDS -->
    <div class="cards">

        <div class="card">
            <i class="fa-solid fa-calendar-plus"></i>
            <h3>Book Appointment</h3>
            "{{ url('') }}"
            <p>Schedule appointments with healthcare professionals.</p>
            <a href="{{ url('appointments/book') }}">Book Now</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-comments"></i>
            <h3>Consult Doctor</h3>
            <p>Start secure chat or video consultation instantly.</p>
            <a href="{{ url('doctors/consult') }}">Start Consultation</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-file-medical"></i>
            <h3>My Appointments</h3>
            <p>Manage and track your appointment history.</p>
            <a href="{{ url('appointments') }}">View Appointments</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-robot"></i>
            <h3>Ask Dr AI</h3>
            <p>Get AI-powered medical guidance and support.</p>
            <a href="{{ url('dr-ai-chat') }}">Ask AI</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-book-open-reader"></i>
            <h3>Health Learning</h3>
            <p>Articles, expert tips, videos and daily wellness guides curated by our doctors.</p>
            <a href="{{ url('health-learn') }}">Start Learning</a>
        </div>

    </div>

</div>

<script>
function toggleMenu() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>
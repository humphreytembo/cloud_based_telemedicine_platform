<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Cloud Telemedicine</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
*{ margin:0; padding:0; box-sizing:border-box; }

body{
    font-family:'Inter',sans-serif;
    background:#f1f5f9;
    color:#1e293b;
    overflow-x:hidden;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    left:0; top:0;
    width:260px;
    height:100vh;
    background:#0f172a;
    padding:25px 20px;
    color:white;
    overflow-y:auto;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:40px;
}

.logo i{ font-size:28px; color:#38bdf8; }
.logo h2{ font-size:20px; font-weight:700; }

.menu{ list-style:none; }
.menu li{ margin-bottom:12px; }

.menu a{
    text-decoration:none;
    color:#cbd5e1;
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    border-radius:12px;
}

.menu a:hover,
.menu .active{
    background:#1e293b;
    color:white;
}

/* MAIN */
.main{
    margin-left:260px;
    padding:30px;
    width:calc(100% - 260px);
}

/* TOPBAR */
.topbar{
    background:white;
    padding:18px 25px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:35px;
}

.stat-link{
    text-decoration:none;
    color:inherit;
    display:block;
}

.stat-card{
    background:white;
    padding:22px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    transition:0.3s;
    height:100%;
}

.stat-card:hover{ transform:translateY(-4px); }
.stat-card i{ font-size:32px; margin-bottom:12px; color:#0ea5e9; }
.stat-card h2{ font-size:26px; }

/* SECTION */
.section-title{ margin-bottom:20px; }

/* DOCTOR CARD */
.doctor-card{
    background:white;
    padding:20px;
    border-radius:20px;
    margin-bottom:15px;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    flex-wrap:wrap;
}

.doctor-left{
    display:flex;
    gap:15px;
    align-items:flex-start;
    flex:1;
    min-width:300px;
}

.doctor-image{
    width:75px; height:75px;
    border-radius:50%;
    object-fit:cover;
}

.doctor-avatar{
    width:75px; height:75px;
    border-radius:50%;
    background:#dbeafe;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#2563eb;
}

.doctor-info h3{ margin-bottom:5px; }
.doctor-info p{ font-size:14px; color:#64748b; margin-bottom:6px; }

.actions{ display:flex; gap:10px; flex-wrap:wrap; }

.actions button{
    border:none;
    padding:10px 14px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.approve{ background:#16a34a; color:white; }
.reject{ background:#ef4444; color:white; }

@media(max-width:950px){
    .sidebar{ width:80px; }
    .main{ margin-left:80px; width:calc(100% - 80px); }
}

@media(max-width:768px){
    .doctor-card{ flex-direction:column; }
}

.document-link{
    display:inline-block;
    margin-top:6px;
    color:#2563eb;
    font-weight:600;
    font-size:13px;
    text-decoration:none;
}

.document-link:hover{ text-decoration:underline; }

.download-btn{
    display:inline-block;
    margin-top:8px;
    background:#0f172a;
    color:white;
    padding:8px 12px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
}

.download-btn:hover{ background:#1e293b; }

.alert{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 20px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:500;
    font-size:14px;
    animation: fadeIn 0.4s ease;
}

.alert-success{
    background:#dcfce7;
    color:#16a34a;
    border:1px solid #bbf7d0;
}

.alert-success i{ font-size:18px; color:#16a34a; }

@keyframes fadeIn{
    from{ opacity:0; transform:translateY(-6px); }
    to{ opacity:1; transform:translateY(0); }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-heart-pulse"></i>
        <h2>CloudMed</h2>
    </div>

    <ul class="menu">
        <li><a class="active"><i class="fa-solid fa-table-columns"></i>Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-user-doctor"></i>Doctors</a></li>
        <li><a href="#"><i class="fa-solid fa-users"></i>Patients</a></li>
        <li><a href="#"><i class="fa-solid fa-calendar-check"></i>Appointments</a></li>
        <li>
            <a href="{{ route('reports.index') }}">
                <i class="fa-solid fa-file-medical"></i>Reports
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- TOPBAR -->
    <div class="topbar">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- STATS -->
    <div class="stats">

        <a class="stat-link" href="{{ route('admin.doctors.pending') }}">
            <div class="stat-card">
                <i class="fa-solid fa-user-doctor"></i>
                <h2>{{ $pendingDoctors->count() }}</h2>
                <p>Pending Doctors</p>
            </div>
        </a>

        <a class="stat-link" href="{{ route('admin.patients') }}">
            <div class="stat-card">
                <i class="fa-solid fa-users"></i>
                <h2>{{ $totalPatients }}</h2>
                <p>Patients</p>
            </div>
        </a>

        <a class="stat-link" href="{{ route('admin.appointments') }}">
            <div class="stat-card">
                <i class="fa-solid fa-calendar-check"></i>
                <h2>{{ $totalAppointments }}</h2>
                <p>Appointments</p>
            </div>
        </a>

        <a class="stat-link" href="{{ route('admin.doctors.approved') }}">
            <div class="stat-card">
                <i class="fa-solid fa-user-doctor"></i>
                <h2>{{ $totalDoctors }}</h2>
                <p>Approved Doctors</p>
            </div>
        </a>

        <a class="stat-link" href="{{ route('reports.index') }}">
            <div class="stat-card">
                <i class="fa-solid fa-file-medical" style="color:#8b5cf6;"></i>
                <h2>{{ $totalReports }}</h2>
                <p>Consultation Reports</p>
            </div>
        </a>

    </div>

    <!-- SECTION -->
    <div class="section-title">
        <h2>Pending Doctor Verification</h2>
    </div>

    <!-- DOCTORS -->
    @forelse($pendingDoctors as $doctor)
    <div class="doctor-card">

        <div class="doctor-left">

            @if($doctor->profile_image)
                <img class="doctor-image" src="{{ asset('storage/' . $doctor->profile_image) }}">
            @else
                <div class="doctor-avatar">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
            @endif

            <div class="doctor-info">
                <h3>{{ $doctor->name }}</h3>
                <p><i class="fa-solid fa-envelope"></i> {{ $doctor->email }}</p>
                <p><i class="fa-solid fa-stethoscope"></i> {{ $doctor->specialization }}</p>

                @if($doctor->doctor_document)
                    <p style="margin-top:8px;">
                        <i class="fa-solid fa-file-medical"></i> Medical Verification Document
                    </p>
                    <a class="document-link"
                       href="{{ asset('storage/'.$doctor->doctor_document) }}"
                       target="_blank">
                        <i class="fa-solid fa-eye"></i> View Document
                    </a>
                    <br>
                    <a class="download-btn"
                       href="{{ asset('storage/'.$doctor->doctor_document) }}"
                       download>
                        <i class="fa-solid fa-download"></i> Download Document
                    </a>
                @else
                    <p style="color:red; margin-top:8px;">No verification document uploaded</p>
                @endif
            </div>

        </div>

        <div class="actions">
            <form method="POST" action="{{ route('approve.doctor', $doctor->id) }}">
                @csrf
                <button class="approve">Approve</button>
            </form>

            <form method="POST" action="{{ route('reject.doctor', $doctor->id) }}">
                @csrf
                <button class="reject">Reject</button>
            </form>
        </div>

    </div>
    @empty
        <div style="background:white;padding:30px;text-align:center;border-radius:14px;color:#94a3b8;box-shadow:0 5px 20px rgba(0,0,0,0.05);">
            <i class="fa-solid fa-circle-check" style="font-size:32px;color:#16a34a;margin-bottom:10px;"></i>
            <p>No pending doctor verifications.</p>
        </div>
    @endforelse

</div>

</body>
</html>
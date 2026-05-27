<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Appointment</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:"Segoe UI",sans-serif;
    background:#f1f5f9;
    min-height:100vh;
    padding:40px 20px;
    color:#1e293b;
}

/* PAGE CONTAINER */
.page{
    max-width:1200px;
    margin:auto;
}

/* TOPBAR */
.topbar{
    background:white;
    padding:20px 25px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    margin-bottom:25px;
}

.topbar-left h1{
    font-size:30px;
    color:#0f172a;
    margin-bottom:5px;
}

.topbar-left p{
    color:#64748b;
    font-size:14px;
}

.back-btn{
    text-decoration:none;
    background:#0ea5e9;
    color:white;
    padding:12px 18px;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}

.back-btn:hover{
    background:#0284c7;
}

/* MAIN CARD */
.card{
    background:white;
    border-radius:24px;
    padding:35px;
    box-shadow:0 10px 35px rgba(0,0,0,0.06);
}

/* HEADER */
.card-header{
    margin-bottom:30px;
}

.card-header h2{
    font-size:32px;
    color:#0f172a;
    margin-bottom:10px;
}

.card-header p{
    color:#64748b;
    font-size:15px;
}

/* SUCCESS MESSAGE */
.success{
    background:#dcfce7;
    color:#166534;
    padding:15px;
    border-radius:12px;
    margin-bottom:25px;
    font-weight:600;
    border-left:5px solid #22c55e;
}

/* FORM GRID */
.form-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:30px;
}

/* SECTION TITLES */
.section-title{
    font-size:20px;
    margin-bottom:18px;
    color:#0f172a;
}

/* DOCTOR GRID */
.doctor-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
    gap:18px;
    margin-bottom:25px;
}

/* DOCTOR CARD */
.doctor-card{
    border:2px solid #e2e8f0;
    border-radius:20px;
    padding:20px;
    cursor:pointer;
    transition:0.3s;
    background:#ffffff;
    position:relative;
    overflow:hidden;
}

.doctor-card:hover{
    transform:translateY(-5px);
    border-color:#0ea5e9;
    box-shadow:0 10px 25px rgba(14,165,233,0.12);
}

.doctor-card.active{
    border:2px solid #0ea5e9;
    background:#f0f9ff;
}

/* IMAGE */
.doctor-img{
    width:85px;
    height:85px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #e0f2fe;
    margin-bottom:15px;
}

/* DOCTOR INFO */
.doctor-card h4{
    font-size:18px;
    color:#0f172a;
    margin-bottom:6px;
}

.specialization{
    display:inline-block;
    background:#dbeafe;
    color:#1d4ed8;
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
    margin-bottom:12px;
}

.doctor-note{
    font-size:13px;
    color:#64748b;
    line-height:1.5;
}

/* FORM BOX */
.form-box{
    background:#f8fafc;
    border-radius:20px;
    padding:25px;
    border:1px solid #e2e8f0;
}

/* LABELS */
label{
    display:block;
    margin-bottom:8px;
    margin-top:18px;
    font-weight:600;
    color:#334155;
    font-size:14px;
}

/* INPUTS */
input,
textarea{
    width:100%;
    padding:14px;
    border:1px solid #cbd5e1;
    border-radius:14px;
    background:white;
    outline:none;
    transition:0.3s;
    font-size:14px;
    color:#0f172a;
}

input:focus,
textarea:focus{
    border-color:#0ea5e9;
    box-shadow:0 0 0 4px rgba(14,165,233,0.15);
}

textarea{
    min-height:130px;
    resize:none;
}

/* BUTTON */
.submit-btn{
    width:100%;
    padding:15px;
    margin-top:25px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#0ea5e9,#2563eb);
    color:white;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}

.submit-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(37,99,235,0.25);
}

/* SIDE PANEL */
.side-panel{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    border-radius:22px;
    padding:30px;
    color:white;
    height:fit-content;
}

.side-panel h3{
    margin-bottom:18px;
    font-size:24px;
}

.side-panel p{
    color:#cbd5e1;
    line-height:1.7;
    margin-bottom:20px;
}

.feature{
    display:flex;
    gap:15px;
    margin-bottom:20px;
    align-items:flex-start;
}

.feature i{
    width:45px;
    height:45px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    background:rgba(255,255,255,0.1);
    font-size:18px;
}

.feature div h4{
    margin-bottom:5px;
}

.feature div small{
    color:#cbd5e1;
    line-height:1.5;
}

/* RESPONSIVE */
@media(max-width:950px){

    .form-grid{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    body{
        padding:20px 15px;
    }

    .topbar{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .topbar-left h1{
        font-size:24px;
    }

    .card{
        padding:20px;
    }

    .doctor-grid{
        grid-template-columns:1fr;
    }

}

</style>
</head>

<body>

<div class="page">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="topbar-left">
            <h1>Book Appointment</h1>
            <p>Schedule secure consultations with professional doctors.</p>
        </div>

        <a href="/home" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back Dashboard
        </a>

    </div>

    <!-- MAIN CARD -->
    <div class="card">

        <div class="card-header">
            <h2>Find Your Doctor</h2>
            <p>Select a doctor and choose your preferred appointment date and time.</p>
        </div>

        @if(session('success'))
        <div class="success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="form-grid">

            <!-- LEFT SIDE -->
            <div>

                <h3 class="section-title">
                    Available Doctors
                </h3>

                <form method="POST" action="/appointments/book">
                @csrf

                <input type="hidden" name="doctor_id" id="doctor_id">

                <!-- DOCTORS -->
                <div class="doctor-grid">

                    @foreach($doctors as $doctor)

                    <div class="doctor-card"
                         onclick="selectDoctor(this, {{ $doctor->id }})">

                        <!-- IMAGE -->
                        <img class="doctor-img"
                             src="{{ $doctor->profile_image ? asset('storage/' . $doctor->profile_image) : 'https://via.placeholder.com/100' }}"
                             alt="Doctor">

                        <!-- NAME -->
                        <h4>Dr. {{ $doctor->name }}</h4>

                        <!-- SPECIALIZATION -->
                        <span class="specialization">
                            {{ $doctor->specialization ?? 'General Practitioner' }}
                        </span>

                        <!-- NOTE -->
                        @if($doctor->doctor_note)
                        <div class="doctor-note">
                            {{ Str::limit($doctor->doctor_note, 80) }}
                        </div>
                        @endif

                    </div>

                    @endforeach

                </div>

                <!-- FORM BOX -->
                <div class="form-box">

                    <label>
                        <i class="fa-solid fa-calendar-days"></i>
                        Appointment Date
                    </label>

                    <input type="date"
                           name="appointment_date"
                           required>

                    <label>
                        <i class="fa-solid fa-clock"></i>
                        Appointment Time
                    </label>

                    <input type="time"
                           name="appointment_time"
                           required>

                    <label>
                        <i class="fa-solid fa-notes-medical"></i>
                        Reason For Visit
                    </label>

                    <textarea
                        name="reason"
                        placeholder="Describe your symptoms or reason for consultation..."
                        required></textarea>

                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        Request Appointment
                    </button>

                </div>

                </form>

            </div>

            <!-- RIGHT SIDE -->
            <div class="side-panel">

                <h3>Why Choose MediCare+?</h3>

                <p>
                    Experience modern cloud-based healthcare consultations
                    from anywhere with secure communication and expert doctors.
                </p>

                <div class="feature">
                    <i class="fa-solid fa-video"></i>

                    <div>
                        <h4>Video Consultation</h4>
                        <small>
                            Connect instantly with doctors through secure video sessions.
                        </small>
                    </div>
                </div>

                <div class="feature">
                    <i class="fa-solid fa-user-shield"></i>

                    <div>
                        <h4>Secure & Private</h4>
                        <small>
                            Your medical information is encrypted and protected.
                        </small>
                    </div>
                </div>

                <div class="feature">
                    <i class="fa-solid fa-clock"></i>

                    <div>
                        <h4>24/7 Accessibility</h4>
                        <small>
                            Access healthcare services anytime from anywhere.
                        </small>
                    </div>
                </div>

                <div class="feature">
                    <i class="fa-solid fa-heart-pulse"></i>

                    <div>
                        <h4>Professional Doctors</h4>
                        <small>
                            Consult certified specialists and healthcare experts.
                        </small>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<script>

function selectDoctor(card, id){

    document.querySelectorAll('.doctor-card').forEach(c => {
        c.classList.remove('active');
    });

    card.classList.add('active');

    document.getElementById('doctor_id').value = id;
}

</script>

</body>
</html>
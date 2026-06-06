<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Available Doctors</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#f3f7fb;
    color:#1e293b;
}

/* MAIN CONTAINER */
.container{
    width:100%;
    max-width:1300px;
    margin:auto;
    padding:40px 20px;
}

/* HERO SECTION */
.hero{
    background:linear-gradient(135deg,#0f172a,#1e3a8a);
    border-radius:25px;
    padding:50px 40px;
    color:white;
    margin-bottom:40px;
    position:relative;
    overflow:hidden;
}

.hero::before{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:rgba(255,255,255,0.06);
    border-radius:50%;
    top:-100px;
    right:-100px;
}

.hero h1{
    font-size:42px;
    font-weight:700;
    margin-bottom:15px;
    position:relative;
    z-index:2;
}

.hero p{
    max-width:650px;
    line-height:1.7;
    color:rgba(255,255,255,0.85);
    position:relative;
    z-index:2;
}

/* TOP AREA */
.top-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

/* BACK BUTTON */
.back-dashboard-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    background:white;
    color:#1e3a8a;
    padding:12px 18px;
    border-radius:14px;
    font-weight:600;
    border:1px solid #dbeafe;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
    transition:0.3s ease;
}

.back-dashboard-btn:hover{
    background:#1e3a8a;
    color:white;
    transform:translateY(-2px);
}

/* SEARCH BOX */
.search-box{
    background:white;
    padding:12px 18px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
    width:300px;
}

.search-box input{
    width:100%;
    border:none;
    outline:none;
    font-size:14px;
    background:none;
}

/* GRID */
.doctor-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

/* CARD */
.doctor-card{
    background:white;
    border-radius:24px;
    padding:25px;
    position:relative;
    overflow:hidden;
    transition:0.35s ease;
    border:1px solid #e5e7eb;
    box-shadow:0 5px 20px rgba(0,0,0,0.04);
}

.doctor-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
}

/* HEADER */
.card-header{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:20px;
}

/* IMAGE */
.doctor-image{
    position:relative;
}

.doctor-image img{
    width:85px;
    height:85px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #dbeafe;
}

/* ONLINE DOT */
.online-dot{
    width:18px;
    height:18px;
    background:#22c55e;
    border-radius:50%;
    border:3px solid white;
    position:absolute;
    bottom:3px;
    right:3px;
}

.offline-dot{
    width:18px;
    height:18px;
    background:#ef4444;
    border-radius:50%;
    border:3px solid white;
    position:absolute;
    bottom:3px;
    right:3px;
}

/* DETAILS */
.doctor-details{
    flex:1;
}

.doctor-name{
    font-size:20px;
    font-weight:700;
    margin-bottom:5px;
    color:#0f172a;
}

.specialty{
    color:#64748b;
    font-size:14px;
    margin-bottom:12px;
}

/* STATUS */
.status{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 14px;
    border-radius:50px;
    font-size:12px;
    font-weight:600;
}

.online{
    background:#dcfce7;
    color:#166534;
}

.offline{
    background:#fee2e2;
    color:#991b1b;
}

/* INFO SECTION */
.info-section{
    margin-top:15px;
}

.info-box{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid #f1f5f9;
    font-size:14px;
}

.info-box:last-child{
    border:none;
}

/* BUTTON */
.card-actions{
    margin-top:25px;
}

.chat-btn{
    width:100%;
    text-align:center;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
    display:block;
}

.chat-btn:hover{
    transform:scale(1.03);
}

/* EMPTY */
.empty{
    background:white;
    padding:60px 20px;
    border-radius:20px;
    text-align:center;
    color:#64748b;
    font-size:18px;
    grid-column:1/-1;
}

/* RESPONSIVE */
@media(max-width:768px){

    .hero{
        padding:35px 25px;
    }

    .hero h1{
        font-size:30px;
    }

    .top-area{
        flex-direction:column;
        align-items:flex-start;
    }

    .search-box{
        width:100%;
    }

}

</style>
</head>

<body>

<div class="container">

    <!-- HERO -->
    <div class="hero">
        <h1>Professional Telemedicine Care</h1>

        <p>
            Connect instantly with certified doctors, specialists,
            and healthcare professionals from anywhere. Secure,
            fast, and reliable online medical consultations.
        </p>
    </div>

    <!-- TOP AREA -->
    <div class="top-area">

        <!-- BACK BUTTON -->
        <a href= "{{ url('/home') }}" class="back-dashboard-btn">
            ← Back to Dashboard
        </a>

        <!-- SEARCH -->
        <div class="search-box">
            <input type="text" placeholder="Search doctor or specialty...">
        </div>

    </div>

    <!-- GRID -->
    <div class="doctor-grid">

        @forelse($doctors as $doctor)

        <div class="doctor-card">

            <!-- HEADER -->
            <div class="card-header">

                <!-- IMAGE -->
                <div class="doctor-image">

                    <img src="{{ $doctor->profile_image 
                        ? asset('storage/' . $doctor->profile_image) 
                        : asset('images/default.png') }}" 
                        alt="Doctor">

                    @if($doctor->is_online)
                        <div class="online-dot"></div>
                    @else
                        <div class="offline-dot"></div>
                    @endif

                </div>

                <!-- DETAILS -->
                <div class="doctor-details">

                    <div class="doctor-name">
                        Dr. {{ $doctor->name }}
                    </div>

                    <div class="specialty">
                        {{ $doctor->specialization ?? 'General Practitioner' }}
                    </div>

                    @if($doctor->is_online)
                        <span class="status online">
                            ● Available Now
                        </span>
                    @else
                        <span class="status offline">
                            ● Offline
                        </span>
                    @endif

                </div>

            </div>

            <!-- EXTRA INFO -->
            <div class="info-section">

                <div class="info-box">
                    <span>Consultation Type</span>
                    <strong>Online</strong>
                </div>

                <div class="info-box">
                    <span>Experience</span>
                    <strong>2+ Years</strong>
                </div>

                
            </div>

            <!-- BUTTON -->
            <div class="card-actions">

                <a href="{{ url('/chat/' . $doctor->id) }}" class="chat-btn">
                    Start Consultation
                </a>

            </div>

        </div>

        @empty

        <div class="empty">
            No doctors available at the moment.
        </div>

        @endforelse

    </div>

</div>

</body>
</html>
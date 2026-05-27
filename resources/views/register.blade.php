<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #dbeafe, #ffffff, #e0e7ff);
    min-height: 100vh;
}

/* background shapes */
.circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    opacity: 0.35;
    z-index: 0;
}

.c1 { width: 300px; height: 300px; background: #60a5fa; top: 50px; left: 80px; }
.c2 { width: 300px; height: 300px; background: #818cf8; bottom: 50px; right: 80px; }

/* container */
.container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 1;
    padding: 20px;
}

/* card */
.card {
    width: 450px;
    background: rgba(255,255,255,0.95);
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    backdrop-filter: blur(10px);
}

/* title */
.title {
    text-align: center;
    margin-bottom: 25px;
}

.title h1 {
    color: #2563eb;
    margin: 0;
    font-size: 28px;
}

.title p {
    font-size: 13px;
    color: #6b7280;
}

/* inputs */
.group {
    margin-bottom: 14px;
}

label {
    font-size: 13px;
    color: #374151;
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
}

input, textarea {
    width: 100%;
    padding: 11px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    outline: none;
    font-size: 14px;
    transition: 0.25s;
}

input:focus, textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
}

/* DOCTOR TOGGLE BOX */
.doctor-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    background: linear-gradient(135deg, #eff6ff, #f8fafc);
    border: 1px solid #dbeafe;
    border-radius: 12px;
    margin: 15px 0;
}

/* DOCTOR LABEL */
.doctor-box label {
    margin: 0;
    font-weight: 600;
    color: #1e3a8a;
    font-size: 13px;
}

/* TOGGLE SWITCH */
.switch {
    position: relative;
    width: 44px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #cbd5e1;
    transition: 0.3s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.switch input:checked + .slider {
    background: #2563eb;
}

.switch input:checked + .slider:before {
    transform: translateX(20px);
}

/* doctor fields */
#doctorFields {
    display: none;
    margin-top: 10px;
    padding: 15px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: 0.3s;
}

/* textarea */
textarea {
    height: 100px;
    resize: none;
}

/* preview image */
.preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    display: none;
    margin-top: 10px;
    border: 2px solid #2563eb;
}

/* button */
.btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    font-size: 15px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
}
</style>
</head>

<body>

<div class="circle c1"></div>
<div class="circle c2"></div>

<div class="container">

<div class="card">

<div class="title">
    <h1>Create Account</h1>
    <p>TeleMed Cloud Platform</p>
</div>

<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
@csrf

<!-- NAME -->
<div class="group">
    <label>Full Name</label>
    <input type="text" name="name" required>
</div>

<!-- EMAIL -->
<div class="group">
    <label>Email Address</label>
    <input type="email" name="email" required>
</div>

<!-- PASSWORD -->
<div class="group">
    <label>Password</label>
    <input type="password" name="password" required>
</div>

<!-- CONFIRM -->
<div class="group">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required>
</div>

<!-- DOCTOR TOGGLE -->
<div class="doctor-box">
    <label>I am a medical doctor</label>

    <label class="switch">
        <input type="checkbox" id="doctorCheck" name="is_doctor" value="1">
        <span class="slider"></span>
    </label>
</div>

<!-- DOCTOR FIELDS -->
<div id="doctorFields">

    <div class="group">
        <label>Profile Image</label>
        <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
        <img id="previewImg" class="preview">
    </div>

    <div class="group">
        <label>Specialization</label>
        <input type="text" name="specialization" placeholder="e.g Cardiologist, Dentist">
    </div>

    <div class="group">
        <label>Medical License / Certificate</label>
        <input type="file" name="doctor_document">
        
    </div>

</div>

<button type="submit" class="btn">Create Account</button>

</form>

</div>

</div>

<script>
const doctorCheck = document.getElementById("doctorCheck");
const doctorFields = document.getElementById("doctorFields");

doctorCheck.addEventListener("change", function () {
    doctorFields.style.display = this.checked ? "block" : "none";
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const img = document.getElementById("previewImg");
        img.src = reader.result;
        img.style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
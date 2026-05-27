<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Telemedicine Platform</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* HERO SECTION */
.hero {
    height: 100vh;
    background: url("{{ asset('images/backroground-home-image.jpg') }}") no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

/* SOFTER OVERLAY (image more visible) */
.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25); /* lighter for clearer image */
}

/* CONTENT (NO BACKGROUND COLOR) */
.card {
    position: relative;
    max-width: 700px;
    padding: 40px;
    text-align: center;
    color: #ffffff;

    /* subtle readability without background box */
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
}

/* TEXT */
h1 {
    font-size: 34px;
    margin-bottom: 15px;
    font-weight: 700;
}

.description {
    color: #f5f5f5;
    margin-bottom: 20px;
    line-height: 1.6;
}

.features {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.features li {
    margin-bottom: 10px;
    color: #f1f1f1;
}

/* BUTTONS */
.buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.btn {
    padding: 12px 25px;
    border-radius: 30px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: 0.3s;
}

/* keep buttons visible */
.login {
    background-color: #007bff;
}

.register {
    background-color: #28a745;
}

.btn:hover {
    transform: translateY(-3px);
    opacity: 0.9;
}

/* MOBILE */
@media (max-width: 600px) {
    .card {
        margin: 20px;
        padding: 25px;
    }

    .buttons {
        flex-direction: column;
    }
}
</style>

</head>

<body>

<main class="hero">

    <div class="card">
        <h1>Cloud Telemedicine Platform 🏥</h1>

        <p class="description">
            Connect with doctors anytime, anywhere. Book appointments, consult online, and manage your health with ease.
        </p>

        <ul class="features">
            <li>👤 Easy patient registration</li>
            <li>👨‍⚕️ Doctor consultation online</li>
            <li>📅 Book appointments instantly</li>
            <li>💊 Access your medical records</li>
        </ul>

        <div class="buttons">
            <a href="{{ route('showlogin') }}" class="btn login">Login</a>
            <a href="{{ route('showregister') }}" class="btn register">Register</a>
        </div>
    </div>

</main>

</body>
</html>
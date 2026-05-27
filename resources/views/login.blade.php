<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TeleMed Cloud - Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #dbeafe, #ffffff, #e0e7ff);
            height: 100vh;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
        }

        .circle1 {
            width: 250px;
            height: 250px;
            background: #60a5fa;
            top: 50px;
            left: 80px;
        }

        .circle2 {
            width: 250px;
            height: 250px;
            background: #818cf8;
            bottom: 50px;
            right: 80px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 1;
        }

        .card {
            width: 380px;
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h1 {
            margin: 0;
            font-size: 28px;
            color: #2563eb;
        }

        .title p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 5px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 13px;
            color: #374151;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        .remember {
            display: flex;
            align-items: center;
            font-size: 13px;
            margin: 10px 0;
            color: #4b5563;
        }

        .remember input {
            width: auto;
            margin-right: 8px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        /* ERROR ALERT */
        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #fecaca;
        }

        /* SUCCESS ALERT — was missing, now added */
        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #bbf7d0;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* LINKS */
        .links-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .links-box a {
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .left-link {
            color: #2563eb;
        }

        .right-link {
            color: #ef4444;
        }

        .links-box a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>

<div class="bg-circle circle1"></div>
<div class="bg-circle circle2"></div>

<div class="container">

    <div class="card">

        <div class="title">
            <h1>TeleMed Cloud</h1>
            <p>Doctor • Patient • Admin Platform</p>
        </div>

        {{-- SUCCESS FLASH (e.g. after registration or doctor signup) --}}
        @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- ERROR FLASH (e.g. wrong password, unapproved doctor) --}}
        @if(session('error'))
            <div class="alert-error">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember">
                <label>Remember me</label>
            </div>

            <button type="submit" class="btn">
                Login
            </button>

            <div class="links-box">

                <a href="{{ route('register') }}" class="left-link">
                    Create account
                </a>

                <a href="/forgot-password" class="right-link">
                    Forgot password?
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
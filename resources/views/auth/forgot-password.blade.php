<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<h2>Forgot Password</h2>

@if(session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

<form method="POST" action="/forgot-password">
    @csrf

    <input type="email" name="email" placeholder="Enter email" required>

    <button type="submit">Send Reset Link</button>
</form>

</body>
</html>
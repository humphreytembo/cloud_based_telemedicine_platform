<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

<h2>Reset Password</h2>

<form method="POST" action="/reset-password">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <input type="email"
           name="email"
           placeholder="Email"
           required>

    <br><br>

    <input type="password"
           name="password"
           placeholder="New Password"
           required>

    <br><br>

    <input type="password"
           name="password_confirmation"
           placeholder="Confirm Password"
           required>

    <br><br>

    <button type="submit">
        Reset Password
    </button>

</form>

</body>
</html>
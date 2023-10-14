<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <h1>Password Reset</h1>

    <p>Hello {{ $user->name }},</p>

    <p>You have requested to reset your password for your account.</p>

    <p>Please click on the following link to reset your password:</p>

    <a href="{{ $resetUrl }}">Reset Password</a>

    <p>If you did not request a password reset, you can safely ignore this email.</p>

    <p>Thank you,</p>
    <p>Your Website Team</p>
</body>
</html>

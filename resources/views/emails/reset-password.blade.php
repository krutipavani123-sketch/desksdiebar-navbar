<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #111827;
        }
        p {
            color: #374151;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .small-text {
            font-size: 12px;
            color: #6b7280;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Your Password</h1>
        <p>You are receiving this email because we received a password reset request for your account.</p>

        <a href="{{ $actionUrl }}" class="button">Reset Password</a>

        <p class="small-text">
            This password reset link will expire in 60 minutes.<br>
            If you did not request a password reset, no further action is required.
        </p>

        <div class="footer">
            Thanks,<br>
            {{ config('app.name') }}
        </div>

        <p class="small-text">
            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your browser:<br>
            {{ $displayableActionUrl }}
        </p>
    </div>
</body>
</html>
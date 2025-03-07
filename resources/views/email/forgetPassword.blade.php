<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fc;
            color: #343a40;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            font-size: 24px;
            color: #4e73df;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 30px;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
        .btn-reset {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #4e73df;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-reset:hover {
            background-color: #3753ba;
        }
        .email-note {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="email-header">
        <h1>Reset Password Anda</h1>
    </div>
    <div class="email-body">
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mereset password akun Anda. Jika Anda tidak melakukan permintaan ini, Anda dapat mengabaikan email ini.</p>
        <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
        <p class="email-note">Link ini hanya berlaku selama 60 menit. Jika Anda memerlukan bantuan lebih lanjut, silakan hubungi kami.</p>
    </div>
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} ALMAWA. Semua Hak Dilindungi.</p>
    </div>
</div>

</body>
</html>

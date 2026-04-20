<!DOCTYPE html>
<html>
<head>
    <title>Medicure 2FA</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        }

        .card {
            width: 420px;
            background: #fff;
            padding: 45px 40px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.10);
            text-align: center;
        }

        .icon {
            width: 65px;
            height: 65px;
            background: #2c7be5;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;
            font-size: 26px;
        }

        h3 {
            margin: 0;
            font-size: 22px;
            color: #1f2d3d;
            font-weight: 600;
        }

        p {
            color: #6b7c93;
            font-size: 13px;
            margin-top: 8px;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #e0e6f0;
            outline: none;
            text-align: center;
            font-size: 16px;
            letter-spacing: 4px;
            background: #f9fbff;
            transition: 0.3s;
        }

        input:focus {
            border-color: #2c7be5;
            box-shadow: 0 0 10px rgba(44,123,229,0.15);
            background: #fff;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 18px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2c7be5, #4f9dff);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #9aa6b2;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="icon">
        <i class="fa-solid fa-shield-halved"></i>
    </div>

    <h3>Two-Factor Verification</h3>

    <p>Enter the 6-digit code sent to your email</p>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf

        <input type="text" name="otp" maxlength="6" placeholder="------" required>

        <button type="submit">
            Verify
        </button>
    </form>

    <div class="footer">
        Medicure Hospital System Security
    </div>

</div>

</body>
</html>
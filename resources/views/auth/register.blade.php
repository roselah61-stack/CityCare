<!DOCTYPE html>
<html>
<head>
    <title>Medicure Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            background: #eaf1ff;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .left {
            width: 60%;
            position: relative;
            background: url('/images/doctors.jpg') center/cover no-repeat;
        }

        .left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(11, 31, 58, 0.55),
                rgba(44, 123, 229, 0.25)
            );
        }

        .right {
            width: 40%;
            background: linear-gradient(135deg, #ffffff, #f4f8ff);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 70px;
            position: relative;
            overflow: hidden;
            border-top-left-radius: 55px;
            border-bottom-left-radius: 55px;
            box-shadow: -10px 0 30px rgba(0,0,0,0.08);
            z-index: 2;
        }

        .right::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255, 122, 24, 0.08);
            border-radius: 50%;
            top: -70px;
            right: -70px;
        }

        .right::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            background: rgba(44, 123, 229, 0.06);
            border-radius: 50%;
            bottom: -90px;
            left: -90px;
        }

        .brand {
            position: relative;
            z-index: 2;
            font-size: 30px;
            font-weight: 800;
            color: #2c7be5;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .register-card {
            position: relative;
            z-index: 2;
            margin-top: 25px;
            background: white;
            padding: 45px 35px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
        }

        h2 {
            font-size: 22px;
            color: #1f2d3d;
            margin-bottom: 25px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 1px solid #e0e6f0;
            border-radius: 10px;
            background: #f9fbff;
            outline: none;
        }

        input:focus {
            border-color: #2c7be5;
            box-shadow: 0 0 10px rgba(44,123,229,0.15);
            background: #fff;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2c7be5, #4f9dff);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .link a {
            color: #2c7be5;
            text-decoration: none;
            font-weight: bold;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        @media (max-width: 1024px) {
            .right {
                width: 45%;
                padding: 50px;
            }

            .left {
                width: 55%;
            }
        }

        @media (max-width: 768px) {
            body {
                overflow: auto;
            }

            .container {
                flex-direction: column;
            }

            .left {
                width: 100%;
                height: 40vh;
            }

            .right {
                width: 100%;
                border-radius: 0;
                padding: 40px 20px;
                box-shadow: none;
            }

            .register-card {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .brand {
                font-size: 22px;
            }

            .brand img {
                width: 40px;
                height: 40px;
            }

            h2 {
                font-size: 20px;
            }
        }

    </style>
</head>

<body>

<div class="container">

    <div class="left"></div>

    <div class="right">

        <div class="brand">
            <img src="{{ asset('images/logo.png') }}">
            Medicure
        </div>

        <div class="register-card">

            <h2>Create Account</h2>

            @if($errors->any())
                <p class="error">{{ $errors->first() }}</p>
            @endif

            <form method="POST" action="/register">
                @csrf

                <input type="text" name="name" placeholder="Full name" required>
                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm password" required>

                <button type="submit">Register</button>
            </form>

            <div class="link">
                <p>Already have an account? <a href="/login">Login</a></p>
            </div>

        </div>

    </div>

</div>

</body>
</html>
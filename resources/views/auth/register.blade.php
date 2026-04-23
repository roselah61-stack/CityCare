<!DOCTYPE html>
<html>
<head>
    <title>CityCare - Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .container-fluid {
            display: flex;
            height: 100vh;
            width: 100%;
            padding: 0;
        }

        .left {
            width: 55%;
            position: relative;
            background: url('/images/doctors.jpg') center/cover no-repeat;
        }

        .left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(21, 51, 142, 0.7), rgba(44, 123, 229, 0.4));
        }

        .welcome-text {
            position: absolute;
            bottom: 80px;
            left: 80px;
            color: white;
            z-index: 2;
            max-width: 500px;
        }

        .welcome-text h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .right {
            width: 45%;
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
            background: rgba(21, 51, 142, 0.05);
            border-radius: 50%;
            top: -70px;
            right: -70px;
        }

        .brand {
            position: relative;
            z-index: 2;
            font-size: 30px;
            font-weight: 800;
            color: #15338e;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 30px;
        }

        .brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .register-card {
            position: relative;
            z-index: 2;
            background: white;
            padding: 40px;
            border-radius: 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            font-size: 24px;
            color: #1f2d3d;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 14px;
        }

        .form-control {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #15338e;
            box-shadow: 0 0 0 4px rgba(21, 51, 142, 0.1);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #15338e 0%, #2460af 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(21, 51, 142, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container-fluid {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            .left {
                width: 100%;
                min-height: 250px;
                order: 2;
                position: relative;
            }

            .right {
                width: 100%;
                padding: 50px 30px;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-radius: 0;
                order: 1;
                min-height: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .welcome-text {
                position: relative;
                bottom: auto;
                left: auto;
                text-align: center;
                margin: 0 auto 40px auto;
                padding: 0 30px;
                max-width: 600px;
            }

            .welcome-text h1 {
                font-size: 32px;
                margin-bottom: 20px;
                line-height: 1.2;
            }

            .welcome-text p {
                font-size: 16px;
                line-height: 1.6;
            }

            .brand {
                font-size: 26px;
                justify-content: center;
                margin-bottom: 30px;
                text-align: center;
            }

            .brand img {
                width: 45px;
                height: 45px;
            }

            .register-card {
                margin: 0 auto;
                padding: 40px 30px;
                max-width: 500px;
                width: 100%;
            }

            h2 {
                font-size: 22px;
                margin-bottom: 25px;
                text-align: center;
            }

            .form-label {
                font-size: 14px;
                margin-bottom: 8px;
            }

            .form-control {
                padding: 14px 16px;
                font-size: 15px;
                border-radius: 8px;
            }

            .btn-primary {
                padding: 16px;
                font-size: 15px;
                border-radius: 8px;
                margin-top: 20px;
            }
        }

        @media (max-width: 768px) {
            .left {
                min-height: 200px;
            }

            .right {
                padding: 40px 25px;
            }

            .welcome-text {
                margin: 0 auto 30px auto;
                padding: 0 25px;
            }

            .welcome-text h1 {
                font-size: 28px;
                margin-bottom: 15px;
            }

            .welcome-text p {
                font-size: 15px;
            }

            .brand {
                font-size: 24px;
                margin-bottom: 25px;
            }

            .brand img {
                width: 40px;
                height: 40px;
            }

            .register-card {
                padding: 35px 25px;
                max-width: 450px;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 13px 15px;
                font-size: 14px;
            }

            .btn-primary {
                padding: 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .left {
                min-height: 180px;
            }

            .right {
                padding: 30px 20px;
            }

            .welcome-text {
                margin: 0 auto 25px auto;
                padding: 0 20px;
            }

            .welcome-text h1 {
                font-size: 24px;
                margin-bottom: 12px;
            }

            .welcome-text p {
                font-size: 14px;
                line-height: 1.5;
            }

            .brand {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .brand img {
                width: 35px;
                height: 35px;
            }

            .register-card {
                padding: 30px 20px;
                max-width: 100%;
            }

            h2 {
                font-size: 18px;
                margin-bottom: 18px;
            }

            .form-label {
                font-size: 13px;
            }

            .form-control {
                padding: 12px 14px;
                font-size: 14px;
            }

            .btn-primary {
                padding: 14px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .left {
                min-height: 150px;
            }

            .right {
                padding: 25px 15px;
            }

            .welcome-text {
                margin: 0 auto 20px auto;
                padding: 0 15px;
            }

            .welcome-text h1 {
                font-size: 22px;
                margin-bottom: 10px;
            }

            .welcome-text p {
                font-size: 13px;
            }

            .brand {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .brand img {
                width: 30px;
                height: 30px;
            }

            .register-card {
                padding: 25px 15px;
            }

            h2 {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .form-control {
                padding: 11px 13px;
                font-size: 13px;
            }

            .btn-primary {
                padding: 13px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="left">
            <div class="welcome-text">
                <h1>Join Our Medical Team</h1>
                <p>Register today to start managing patient care with CityCare Medical Centre's advanced healthcare platform.</p>
            </div>
        </div>

        <div class="right">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>CityCare</span>
            </a>

            <div class="register-card">
                <h2>Create Account</h2>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@citycare.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <div class="mt-4 text-center">
                    <span class="text-muted small">Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-primary small fw-bold text-decoration-none ms-1">Sign In</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

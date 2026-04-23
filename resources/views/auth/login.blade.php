<!DOCTYPE html>
<html>
<head>
    <title>CityCare - Login</title>

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
            width: 45%;
            background: linear-gradient(135deg, #ffffff, #f4f8ff);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            position: relative;
            overflow: hidden;
            border-top-right-radius: 55px;
            border-bottom-right-radius: 55px;
            box-shadow: 10px 0 30px rgba(0,0,0,0.08);
            z-index: 2;
        }

        .left::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(21, 51, 142, 0.05);
            border-radius: 50%;
            top: -70px;
            left: -70px;
        }

        .left::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            background: rgba(44, 123, 229, 0.06);
            border-radius: 50%;
            bottom: -90px;
            right: -90px;
        }

        .brand {
            position: relative;
            z-index: 2;
            font-size: 32px;
            font-weight: 800;
            color: #15338e;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .login-card {
            position: relative;
            z-index: 2;
            margin-top: 30px;
            background: white;
            padding: 45px 35px;
            border-radius: 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
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
            padding: 12px 16px;
            border-radius: 12px;
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
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(21, 51, 142, 0.2);
        }

        .right {
            width: 55%;
            position: relative;
            background: url('/images/doctors.jpg') center/cover no-repeat;
        }

        .right::before {
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

        .welcome-text p {
            font-size: 18px;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column;
            }

            .left {
                width: 100%;
                padding: 40px 20px;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-radius: 0;
                min-height: auto;
                order: 2;
            }

            .right {
                width: 100%;
                padding: 40px 20px;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-radius: 0;
                order: 1;
                min-height: auto;
            }

            .welcome-text {
                position: relative;
                bottom: auto;
                left: auto;
                text-align: center;
                margin-bottom: 30px;
            }

            .welcome-text h1 {
                font-size: 28px;
                margin-bottom: 15px;
            }

            .welcome-text p {
                font-size: 14px;
                line-height: 1.5;
            }

            .brand {
                font-size: 24px;
                justify-content: center;
                margin-bottom: 20px;
            }

            .brand img {
                width: 40px;
                height: 40px;
            }

            .login-card {
                margin: 0 auto 30px auto;
                padding: 30px 20px;
                max-width: 100%;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 20px;
                text-align: center;
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
                padding: 30px 15px;
            }

            .right {
                padding: 30px 15px;
            }

            .login-card {
                padding: 25px 15px;
            }

            .brand {
                font-size: 20px;
            }

            .brand img {
                width: 35px;
                height: 35px;
            }

            h2 {
                font-size: 18px;
            }

            .welcome-text h1 {
                font-size: 24px;
            }

            .welcome-text p {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="left">
            <a href="/" class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>CityCare</span>
            </a>

            <div class="login-card">
                <h2>Welcome Back!</h2>

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@citycare.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>

                <div class="mt-4 text-center">
                    <span class="text-muted small">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-primary small fw-bold text-decoration-none ms-1">Register Now</a>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="welcome-text">
                <h1>Professional Healthcare Excellence</h1>
                <p>Welcome to CityCare Medical Centre. We are committed to providing the highest quality medical care with compassion and innovation.</p>
            </div>
        </div>
    </div>

</body>
</html>

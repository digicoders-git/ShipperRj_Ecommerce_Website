<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back | Admin Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --brand-orange: #ff7e3b;
            --brand-gradient: linear-gradient(135deg, #ff8c42 0%, #ff6b3d 100%);
            --text-dark: #1a1a1a;
            --text-muted: #737373;
            --input-bg: #f8f9fa;
        }

        body {
            background-color: #f1f3f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: #ffffff;
            border-radius: 40px;
            width: 100%;
            max-width: 1000px;
            /* Slightly narrower */
            min-height: 550px;
            /* Reduced height from 700px */
            display: flex;
            overflow: hidden;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* Left Side Illustration Area */
        .illustration-side {
            flex: 1;
            background: var(--brand-gradient);
            padding: 40px;
            /* Reduced from 60px */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            margin: 15px;
            border-radius: 25px;
            overflow: hidden;
            display: none;
            /* Hidden on mobile */
        }

        @media (min-width: 992px) {
            .illustration-side {
                display: flex;
            }
        }

        .illustration-content h1 {
            color: #ffffff;
            font-weight: 800;
            font-size: 2.2rem;
            /* Reduced from 3rem */
            line-height: 1.1;
            margin-bottom: 15px;
            letter-spacing: -1px;
        }

        .illustration-content p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            /* Reduced from 1.1rem */
            max-width: 350px;
            line-height: 1.5;
        }

        .illustration-img-wrapper {
            position: relative;
            margin-top: 10px;
            height: 250px;
            /* Reduced from 350px */
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.15));
        }

        /* Right Side Form Area */
        .form-side {
            flex: 1;
            padding: 40px 60px;
            /* Reduced padding */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 576px) {
            .form-side {
                padding: 40px 30px;
            }
        }

        .login-header {
            width: 100%;
            max-width: 400px;
            margin-bottom: 40px;
        }

        .brand-hub {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .logo-circle {

            background: #656464ff;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
        }

        .logo-circle img {
            width: 100px;
            object-fit: contain;
        }

        .brand-name {
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        @media (max-width: 991px) {
            .brand-name {
                display: none;
                /* Hide text on mobile as requested */
            }

            .brand-hub {
                justify-content: center !important;
                /* Center logo container */
                width: 100%;
            }
        }

        .welcome-text {
            font-weight: 800;
            font-size: 1.8rem;
            /* Reduced from 2.2rem */
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .subtitle-text {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
        }

        .input-group-custom {
            margin-bottom: 25px;
            position: relative;
        }

        .form-control-custom {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid #d1d5db;
            /* Stronger gray border */
            padding: 16px 20px;
            border-radius: 15px;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-custom:focus {
            outline: none;
            background: #fff;
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 4px rgba(255, 126, 59, 0.1);
            /* Glow effect */
            border-width: 2px;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 35%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            height: 100%;
            /* Ensures it centers relative to parent height */
        }

        .forgot-link {
            display: block;
            text-align: right;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
        }

        .forgot-link:hover {
            color: var(--brand-orange);
        }

        .btn-login {
            width: 100%;
            background: var(--brand-gradient);
            color: #fff;
            border: none;
            padding: 16px;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1rem;
            margin-top: 30px;
            box-shadow: 0 15px 30px rgba(255, 126, 59, 0.3);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(255, 126, 59, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ccc;
            margin: 40px 0;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }

        .divider:not(:empty)::before {
            margin-right: 1.5em;
        }

        .divider:not(:empty)::after {
            margin-left: 1.5em;
        }

        .social-buttons {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #fff;
            border: 1px solid #eee;
            padding: 12px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .btn-social:hover {
            background: #f8f9fa;
            border-color: #ddd;
        }

        .signup-text {
            margin-top: 40px;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .signup-text a {
            color: var(--brand-orange);
            text-decoration: none;
            font-weight: 800;
        }

        /* Right Floating Alert for Error Messages (Admin Style) */
        .right-alert-wrapper {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 9999;
            max-width: 320px;
            animation: slideInRight 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-premium-toast {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-left: 5px solid #ef4444;
            border-radius: 20px;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .alert-premium-toast::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        }

        /* Abstract shapes */
        .shape-circle {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            left: -50px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Left Side -->
        <div class="illustration-side">
            <div class="shape-circle"></div>
            <div class="illustration-content">
                <h1>Simplify<br>management with<br>our dashboard.</h1>
                <p>Empower your business with our all-in-one administration suite. Monitor, manage, and scale with ease.
                </p>
            </div>

            <div class="illustration-img-wrapper">
                <img src="{{ asset('assets/images/login_3d.png') }}" alt="Dashboard Illustration"
                    class="illustration-img">
            </div>
        </div>

        <!-- Right Side -->
        <div class="form-side">
            <div class="login-header text-center text-lg-start">
                <div class="brand-hub justify-content-center justify-content-lg-start">
                    <div class="logo-circle">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="Shop Logo">
                    </div>
                    <span class="brand-name">Shopping Club India</span>
                </div>

                <h2 class="welcome-text">Welcome Back</h2>
                <p class="subtitle-text">Please login to your account</p>
            </div>

            @if(session('error'))
                <div class="right-alert-wrapper">
                    <div class="alert-premium-toast">
                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center text-danger"
                            style="width: 45px; height: 45px; flex-shrink: 0; border: 1px solid rgba(239, 68, 68, 0.15);">
                            <i class="bi bi-shield-lock-fill fs-4"></i>
                        </div>
                        <div class="pe-3">
                            <p class="mb-0 x-small fw-medium text-muted" style="line-height: 1.4;">{{ session('error') }}
                            </p>
                        </div>
                        <button type="button" class="btn-close ms-auto small opacity-50"
                            onclick="this.parentElement.parentElement.remove()" style="font-size: 0.7rem;"></button>
                    </div>
                </div>
            @endif

            <form class="login-form" action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="input-group-custom">
                    <input type="email" name="email" class="form-control-custom" placeholder="Email address" required>
                </div>

                <div class="input-group-custom">
                    <input type="password" name="password" id="adminPass" class="form-control-custom"
                        placeholder="Password" required>
                    <i class="bi bi-eye password-toggle" onclick="togglePass()"></i>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="signup-text">
                    Don't have an account? <a href="{{ url('/') }}">Return Home</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePass() {
            const passInput = document.getElementById('adminPass');
            const icon = event.target;
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>

</html>
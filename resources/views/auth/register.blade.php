<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'CafeEase') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Matches the soft cream background from your dashboard */
            background-color: #fdfaf6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 24px;
            /* Soft shadow matching your dashboard cards */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .header {
            /* Matches the dark brown header color from your dashboard */
            background-color: #4a3429;
            color: #fffaf0;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.6rem;
            margin-bottom: 0.4rem;
            letter-spacing: 0.5px;
        }

        .header p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .form-content {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 600;
            color: #4a3429;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            /* Matches the tan/beige input style */
            background-color: #f8f5f0;
            border: 1.5px solid #ece8e1;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #4a3429;
            transition: all 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #d4a373;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            /* Primary brown brand color */
            background-color: #4a3429;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: #38281f;
            transform: translateY(-1px);
        }

        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #8c7e74;
        }

        .footer-links a {
            color: #d4a373;
            text-decoration: none;
            font-weight: 600;
        }

        .is-invalid {
            border-color: #e63946 !important;
        }

        .error-text {
            color: #e63946;
            font-size: 0.75rem;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <div class="header">
            <h1>☕ CafeEase</h1>
            <p>Join the team - Create your account</p>
        </div>

        <div class="form-content">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="e.g. Juan Dela Cruz" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="name@cafeease.com" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Assigned Role</label>
                    <select name="role" required class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                        <option value="" disabled selected>Select Role</option>
                        <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        <option value="barista" {{ old('role') == 'barista' ? 'selected' : '' }}>Barista</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-register">
                    Create Account
                </button>

                <div class="footer-links">
                    Already registered? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

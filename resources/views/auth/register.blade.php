<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPUP Agro Marketplace</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2d7a3e 0%, #4CAF50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            padding: 3rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h1 {
            color: #2d7a3e;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .register-header p {
            color: #424242;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #212121;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .text-center {
            text-align: center;
            margin-top: 1.5rem;
        }

        .text-center a {
            color: #4CAF50;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            padding: 1rem 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <img src="{{ asset('spup final logo.png') }}" alt="SPUP Logo" style="height: 80px; margin-bottom: 1rem;">
            <h1>Register</h1>
            <p>Create your account</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">I am registering as:</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="role" value="buyer" id="buyer" {{ old('role') === 'buyer' ? 'checked' : 'checked' }}>
                        <label for="buyer">Buyer</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="role" value="seller" id="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                        <label for="seller">Seller (Rice Farmer)</label>
                    </div>
                </div>
                <small style="color: #666;">Note: Seller accounts require admin approval</small>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <div class="text-center">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
</body>
</html>

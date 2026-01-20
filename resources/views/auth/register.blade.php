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
            height: 100vh;
            display: flex;
        }

        .left-side {
            flex: 1;
            background: linear-gradient(180deg, #2d7a3e 0%, #1a5028 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 3rem;
        }

        .left-side img {
            width: 120px;
            margin-bottom: 2rem;
            background-color: white;
            padding: 1rem;
            border-radius: 50%;
        }

        .left-side h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .left-side p {
            font-size: 1.1rem;
            text-align: center;
            opacity: 0.9;
            max-width: 400px;
        }

        .right-side {
            flex: 1;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 480px;
        }

        .form-container h2 {
            color: #212121;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .form-container .subtitle {
            color: #666;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #424242;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background-color: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            background-color: #2d7a3e;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-register:hover {
            background-color: #1a5028;
        }

        .alert {
            padding: 0.9rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background-color: #ffebee;
            border-left: 4px solid #d32f2f;
            color: #721c24;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .login-link a {
            color: #2d7a3e;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .role-card {
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: white;
            text-align: center;
        }

        .role-card input[type="radio"] {
            display: none;
        }

        .role-card:hover {
            border-color: #4CAF50;
        }

        .role-card input[type="radio"]:checked + label {
            color: #2d7a3e;
            font-weight: 600;
        }

        .role-card input[type="radio"]:checked ~ .role-card {
            border-color: #2d7a3e;
            background-color: #f1f8f4;
        }

        .role-option {
            position: relative;
            display: block;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .role-option label {
            display: block;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: white;
            text-align: center;
        }

        .role-option input[type="radio"]:checked + label {
            border-color: #2d7a3e;
            background-color: #f1f8f4;
            color: #2d7a3e;
            font-weight: 600;
        }

        .role-option label:hover {
            border-color: #4CAF50;
        }

        small {
            display: block;
            color: #d32f2f;
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .note-text {
            color: #666;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="left-side">
        <img src="{{ asset('spup final logo.png') }}" alt="SPUP Logo">
        <h1>Join Us Today</h1>
        <p>Create an account to start buying or selling rice in the marketplace</p>
    </div>

    <div class="right-side">
        <div class="form-container">
            <h2>Create Account</h2>
            <p class="subtitle">Fill in your details to get started</p>

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
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your.email@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="At least 6 characters" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter your password" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Register As:</label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" name="role" value="buyer" id="buyer" {{ old('role') === 'buyer' ? 'checked' : 'checked' }}>
                            <label for="buyer">Buyer</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" value="seller" id="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                            <label for="seller">Seller (Farmer)</label>
                        </div>
                    </div>
                    <p class="note-text">Note: Seller accounts require administrator approval</p>
                </div>

                <button type="submit" class="btn-register">Create Account</button>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

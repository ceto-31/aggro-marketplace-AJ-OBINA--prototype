<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPUP Agro Marketplace</title>
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
        }

        .form-container {
            width: 100%;
            max-width: 420px;
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

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            color: #666;
        }

        .btn-login {
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

        .btn-login:hover {
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

        .alert-success {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            color: #155724;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .register-link a {
            color: #2d7a3e;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        small {
            display: block;
            color: #d32f2f;
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="left-side">
        <img src="{{ asset('spup final logo.png') }}" alt="SPUP Logo">
        <h1>Welcome Back</h1>
        <p>Sign in to access the Agro Marketplace and connect with rice farmers and buyers</p>
    </div>

    <div class="right-side">
        <div class="form-container">
            <h2>Sign In</h2>
            <p class="subtitle">Enter your credentials to continue</p>

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your.email@example.com" required autofocus>
                    @error('email')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    @error('password')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <div class="register-link">
                <p>Don't have an account? <a href="{{ route('register') }}">Create one now</a></p>
            </div>
        </div>
    </div>
</body>
</html>

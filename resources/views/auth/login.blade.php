<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library Book Request</title>
    <style>
        body {
            background-color: #F1F4F9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Kotak dibikin lebih lebar jadi 500px */
        .login-card {
            background-color: white;
            width: 100%;
            max-width: 500px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        .login-header {
            background-color: #003366;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px; /* Jarak logo dan teks */
        }
        .login-header img {
            max-width: 60px; /* Ukuran logo disesuaikan */
            height: auto;
        }
        .header-text {
            text-align: left;
        }
        .login-body {
            padding: 40px; /* Jarak dalam form diperluas */
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: #003366;
        }
        .btn-login {
            background-color: #003366;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-login:hover {
            background-color: #002244;
        }
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/logo-unair.png') }}" alt="Logo UNAIR">
            <div class="header-text">
                <div style="color: white; font-weight: bold; font-size: 20px;">LIBRARY BOOK REQUEST</div>
                <div style="color: white; font-size: 12px; margin-top: 3px;">PERPUSTAKAAN UNIVERSITAS AIRLANGGA</div>
            </div>
        </div>

        <div class="login-body">
            @if (session('status'))
                <div style="color: red; margin-bottom: 15px; text-align: center; font-size: 14px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Username</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required />
                    @error('password')
                        <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Log in
                </button>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </form>
        </div>
    </div>

</body>
</html>
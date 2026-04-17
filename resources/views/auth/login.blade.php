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
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container .form-control {
            padding-right: 40px; 
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
        }
        .toggle-password svg {
            width: 20px;
            height: 20px;
        }
        .toggle-password:hover {
            color: #003366; 
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
                    <div class="password-container">
                        <input id="password" class="form-control" type="password" name="password" required />
                        
                        <span class="toggle-password" id="togglePassword" title="Show/Hide Password">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </span>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                // Cek tipe input sekarang
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti icon SVG (Mata terbuka vs Mata tercoret)
                if (type === 'text') {
                    this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`;
                } else {
                    this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>`;
                }
            });
        });
    </script>
</body>
</html>
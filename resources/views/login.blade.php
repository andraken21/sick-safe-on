<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.10);
            display: flex;
            width: 700px;
            max-width: 95vw;
            min-height: 410px;
            overflow: hidden;
        }

        .left-panel {
            background: linear-gradient(160deg, #e6f7f2 0%, #c8ece2 100%);
            width: 260px;
            min-width: 220px;
        }

        .right-panel {
            flex: 1;
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a2e3b;
            margin-bottom: 4px;
        }

        .right-panel .subtitle {
            font-size: 0.9rem;
            color: #8a9bb0;
            margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: #2d3e50;
            margin-bottom: 6px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 11px 42px 11px 14px;
            border: 1.5px solid #dde4ec;
            border-radius: 9px;
            font-size: 0.95rem;
            color: #2d3e50;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus { border-color: #2dc98a; background: #fff; }
        input::placeholder { color: #b5c3cf; }

        /* Password wrapper */
        .password-wrapper { position: relative; }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
        }
        .toggle-password:hover svg { stroke: #2dc98a; }

        /* Password rules */
        .password-rules {
            margin-top: 10px;
            padding: 10px 14px;
            border: 1.5px solid #dde4ec;
            border-radius: 9px;
            display: none;
            flex-direction: column;
            gap: 6px;
            background: #f8fafc;
        }
        .password-rules.show { display: flex; }

        .rule {
            font-size: 0.82rem;
            color: #e53935;
            display: flex;
            gap: 8px;
            align-items: center;
            transition: color 0.2s;
        }
        .rule.valid { color: #2dc98a; }
        .rule-icon { width: 14px; text-align: center; font-weight: 700; }

        /* Lupa kata sandi */
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.83rem;
            color: #2dc98a;
            text-decoration: none;
            margin-top: 8px;
        }
        .forgot-link:hover { text-decoration: underline; }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #2dc98a;
        }
        .remember-row label {
            font-size: 0.85rem;
            color: #8a9bb0;
            margin: 0;
            font-weight: 400;
        }

        /* Tombol masuk */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, #2dc98a 0%, #1aaf74 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 16px;
            transition: box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(45,201,138,0.18);
        }
        .btn-login:hover { box-shadow: 0 6px 18px rgba(45,201,138,0.30); }

        /* Daftar */
        .register-text {
            text-align: center;
            margin-top: 18px;
            font-size: 0.88rem;
            color: #8a9bb0;
        }
        .register-text a {
            color: #2dc98a;
            font-weight: 600;
            text-decoration: none;
        }
        .register-text a:hover { text-decoration: underline; }

        /* Alert */
        .alert-success {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.87rem;
            margin-bottom: 16px;
        }

        /* Sembunyikan ikon bawaan browser */
        input::-ms-reveal,
        input::-ms-clear { display: none; }

        @media (max-width: 580px) {
            .left-panel { display: none; }
            .right-panel { padding: 36px 24px; }
            .login-card { border-radius: 14px; }
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- Panel kiri --}}
    <div class="left-panel">
        {{-- Taruh ilustrasi/foto di sini --}}
    </div>

    {{-- Panel kanan --}}
    <div class="right-panel">

        <h1>Selamat Datang</h1>
        <p class="subtitle">Silakan masuk ke akun Anda</p>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    placeholder="user@email.com"
                    value="{{ old('email') }}"
                    required autocomplete="email" autofocus>
                @error('email')
                    <span style="color:#e53935;font-size:0.80rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kata Sandi --}}
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password"
                        placeholder="••••••••••"
                        required autocomplete="current-password">

                    {{-- Tombol toggle mata --}}
                    <button type="button" class="toggle-password" onclick="togglePassword()" title="Tampilkan kata sandi">
                        {{-- Mata terbuka --}}
                        <svg id="icon-eye" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="#b5c3cf" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        {{-- Mata dicoret --}}
                        <svg id="icon-eye-off" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="#b5c3cf" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>

                @error('password')
                    <span style="color:#e53935;font-size:0.80rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror

                {{-- Checklist validasi --}}
                <div class="password-rules" id="password-rules">
                    <div class="rule" id="rule-length">
                        <span class="rule-icon">x</span>
                        <span>Minimal 8 karakter</span>
                    </div>
                    <div class="rule" id="rule-upper">
                        <span class="rule-icon">x</span>
                        <span>Minimal 1 huruf kapital (A-Z)</span>
                    </div>
                    <div class="rule" id="rule-number">
                        <span class="rule-icon">x</span>
                        <span>Minimal 1 angka (0-9)</span>
                    </div>
                    <div class="rule" id="rule-special">
                        <span class="rule-icon">x</span>
                        <span>Minimal 1 karakter spesial (!@#$...)</span>
                    </div>
                </div>

                <a href="#" class="forgot-link">Lupa kata sandi?</a>
            </div>

            {{-- Ingat saya --}}
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <p class="register-text">
            Belum punya akun? <a href="/register">Daftar di sini</a>
        </p>

    </div>
</div>

<script>
    // Toggle tampilkan/sembunyikan password
    function togglePassword() {
        const input  = document.getElementById('password');
        const eyeOn  = document.getElementById('icon-eye');
        const eyeOff = document.getElementById('icon-eye-off');

        if (input.type === 'password') {
            input.type           = 'text';
            eyeOn.style.display  = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type           = 'password';
            eyeOn.style.display  = 'block';
            eyeOff.style.display = 'none';
        }
    }

    // Validasi password real-time
    const passwordInput = document.getElementById('password');
    const rulesBox      = document.getElementById('password-rules');

    passwordInput.addEventListener('input', function () {
        const val = this.value;

        // Tampilkan/sembunyikan kotak rules
        val.length > 0
            ? rulesBox.classList.add('show')
            : rulesBox.classList.remove('show');

        // Update tiap rule
        updateRule('rule-length',  val.length >= 8);
        updateRule('rule-upper',   /[A-Z]/.test(val));
        updateRule('rule-number',  /[0-9]/.test(val));
        updateRule('rule-special', /[!@#$%^&*(),.?":{}|<>]/.test(val));
    });

    function updateRule(id, valid) {
        const el   = document.getElementById(id);
        const icon = el.querySelector('.rule-icon');

        if (valid) {
            el.classList.add('valid');
            icon.textContent = '✓';
        } else {
            el.classList.remove('valid');
            icon.textContent = 'x';
        }
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v=10">
</head>
<body>

<div class="login-card">

    {{-- Logo pojok kiri atas --}}
    <div class="logo-corner">
        <img src="{{ asset('image/logo.png') }}" alt="Logo Saya" width="50" height="50">
    </div>

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

                <input type="email"
                    id="email"
                    name="email"
                    placeholder="user@email.com"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus>

                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kata Sandi --}}
            <div class="form-group">

                <label for="password">Kata Sandi</label>

                <div class="password-wrapper">

                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••••"
                        required
                        autocomplete="current-password">

                    {{-- Tombol toggle mata --}}
                    <button type="button"
                        class="toggle-password"
                        onclick="togglePassword()"
                        title="Tampilkan kata sandi">

                        {{-- Mata terbuka --}}
                        <svg id="icon-eye"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#b5c3cf"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            style="display:block;">

                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>

                        {{-- Mata dicoret --}}
                        <svg id="icon-eye-off"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#b5c3cf"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            style="display:none;">

                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>

                    </button>

                </div>

                @error('password')
                    <span class="error-msg">{{ $message }}</span>
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

                <a href="/forgot" class="forgot-link">
                    Lupa kata sandi?
                </a>

</div>

            {{-- Ingat saya --}}
            <div class="remember-row">

                <input type="checkbox"
                    id="remember"
                    name="remember" required>

                <label for="remember">
                    Ingat saya
                </label>

            </div>

            <button type="submit" class="btn-login">
                Masuk
            </button>

        </form>

        <p class="register-text">
            Belum punya akun?
            <a href="/register">Daftar di sini</a>
        </p>

    </div>
</div>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>
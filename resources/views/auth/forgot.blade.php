<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot</title>
    <link rel="stylesheet" href="{{ asset('css/forgot.css') }}">
</head>
<body>

<div class="card">

    {{-- Logo pojok kiri atas --}}
    <div class="logo-corner">
        <img src="{{ asset('image/logo.png') }}" alt="Logo Saya" width="50" height="50">
    </div>

    {{-- Panel Kiri --}}
    <div class="left">
        <!-- nanti kita buat fotonya disini -->
    </div>

    {{-- Panel Kanan --}}
    <div class="right">

        <h1>Lupa kata sandi?</h1>
        <p class="subtitle">Buat kata sandi baru untuk akunmu.</p>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="/reset-password-direct">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    placeholder="user@email.com"
                    value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required autocomplete="email" autofocus>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kata Sandi Baru --}}
            <div class="form-group">
                <label for="password">Kata sandi baru</label>
                <div class="pw-wrap">
                    <input type="password" id="password" name="password"
                        placeholder="Minimal 8 karakter"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required autocomplete="new-password">

                    <button type="button" class="toggle-btn"
                        onclick="togglePw('password', 'eye-pw', 'eyeoff-pw')"
                        title="Tampilkan kata sandi">
                        <svg id="eye-pw" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eyeoff-pw" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>

                <div class="password-rules" id="password-rules">
                    <div class="rule" id="rule-length">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 8 karakter</span>
                    </div>
                    <div class="rule" id="rule-upper">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 1 huruf kapital (A-Z)</span>
                    </div>
                    <div class="rule" id="rule-number">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 1 angka (0-9)</span>
                    </div>
                    <div class="rule" id="rule-special">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 1 karakter spesial (!@#$...)</span>
                    </div>
                </div>

                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi kata sandi</label>
                <div class="pw-wrap">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi kata sandi baru"
                        class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        required autocomplete="new-password">

                    <button type="button" class="toggle-btn"
                        onclick="togglePw('password_confirmation', 'eye-conf', 'eyeoff-conf')"
                        title="Tampilkan konfirmasi">
                        <svg id="eye-conf" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eyeoff-conf" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>

                <div class="mismatch-msg" id="mismatch-msg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Kata sandi tidak cocok
                </div>

                @error('password_confirmation')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Simpan kata sandi baru</button>
        </form>

        <a href="/auth/login" class="back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke halaman login
        </a>

    </div>
</div>

<script>
    function togglePw(inputId, eyeId, eyeOffId) {
        const input  = document.getElementById(inputId);
        const eye    = document.getElementById(eyeId);
        const eyeOff = document.getElementById(eyeOffId);
        if (input.type === 'password') {
            input.type           = 'text';
            eye.style.display    = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type           = 'password';
            eye.style.display    = 'block';
            eyeOff.style.display = 'none';
        }
    }

    const passwordInput = document.getElementById('password');
    const confInput     = document.getElementById('password_confirmation');
    const rulesBox      = document.getElementById('password-rules');
    const mismatchMsg   = document.getElementById('mismatch-msg');

    passwordInput.addEventListener('input', function () {
        const val = this.value;

        val.length > 0
            ? rulesBox.classList.add('show')
            : rulesBox.classList.remove('show');

        const checks = [
            val.length >= 8,
            /[A-Z]/.test(val),
            /[0-9]/.test(val),
            /[!@#$%^&*(),.?":{}|<>]/.test(val)
        ];

        updateRule('rule-length',  checks[0]);
        updateRule('rule-upper',   checks[1]);
        updateRule('rule-number',  checks[2]);
        updateRule('rule-special', checks[3]);

        // Sembunyikan rules jika semua valid
        if (checks.every(Boolean)) {
            setTimeout(() => rulesBox.classList.remove('show'), 600);
        }

        checkMatch();
    });

    confInput.addEventListener('input', checkMatch);

    function checkMatch() {
        if (confInput.value.length === 0) {
            mismatchMsg.classList.remove('show');
            confInput.classList.remove('is-invalid');
            return;
        }
        if (passwordInput.value !== confInput.value) {
            mismatchMsg.classList.add('show');
            confInput.classList.add('is-invalid');
        } else {
            mismatchMsg.classList.remove('show');
            confInput.classList.remove('is-invalid');
        }
    }

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
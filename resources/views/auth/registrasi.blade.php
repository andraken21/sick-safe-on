<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">`
</head>
<body>

<div class="register-card">
   
    {{-- Panel Kiri --}}
    <div class="left-panel">
        <div class="left-panel-icon">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                stroke="#2dc98a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <h2>Buat Akun Baru</h2>
        <p>Lengkapi data diri kamu untuk mendaftar.</p>
    </div>

    {{-- Panel Kanan --}}
    <div class="right-panel">

        <h1>Daftar Akun</h1>
        <p class="subtitle">Isi semua kolom di bawah ini dengan benar.</p>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="form-grid">

                {{-- ── Seksi: Data Pribadi ── --}}
                <div class="section-label">Data Pribadi</div>

                {{-- Nama --}}
                <div class="form-group">
                    <label for="name" class="label-required">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        placeholder="Nama lengkap"
                        value="{{ old('name') }}"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                        required autocomplete="name">
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NIK --}}
                <div class="form-group">
                    <label for="nik" class="label-required">NIK</label>
                    <input type="text" id="nik" name="nik"
                        placeholder="16 digit NIK"
                        value="{{ old('nik') }}"
                        class="{{ $errors->has('nik') ? 'is-invalid' : '' }}"
                        maxlength="16"
                        required>
                    @error('nik')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div class="form-group">
                    <label for="ttl" class="label-required">Tanggal Lahir</label>
                    <input type="date" id="ttl" name="ttl"
                        value="{{ old('ttl') }}"
                        class="{{ $errors->has('ttl') ? 'is-invalid' : '' }}"
                        required>
                    @error('ttl')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="form-group">
                    <label for="gender" class="label-required">Jenis Kelamin</label>
                    <select id="gender" name="gender"
                        class="{{ $errors->has('gender') ? 'is-invalid' : '' }}"
                        required>
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group full-width">
                    <label for="alamat" class="label-required">Alamat</label>
                    <textarea id="alamat" name="alamat"
                        placeholder="Jalan, kelurahan, kecamatan, kota..."
                        class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                        required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Seksi: Kontak & Akun ── --}}
                <div class="section-label">Kontak & Akun</div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="label-required">Email</label>
                    <input type="email" id="email" name="email"
                        placeholder="user@email.com"
                        value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required autocomplete="email">
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div class="form-group">
                    <label for="no_telp" class="label-required">No. Telepon</label>
                    <input type="tel" id="no_telp" name="no_telp"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('no_telp') }}"
                        class="{{ $errors->has('no_telp') ? 'is-invalid' : '' }}"
                        required>
                    @error('no_telp')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Seksi: Password ── --}}
                <div class="section-label">Kata Sandi</div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="label-required">Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                            placeholder="Minimal 8 karakter"
                            class="pw-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required autocomplete="new-password">
                        <button type="button" class="toggle-password"
                            onclick="togglePw('password','eye-pw','eyeoff-pw')"
                            title="Tampilkan">
                            <svg id="eye-pw" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeoff-pw" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    <div class="password-rules" id="password-rules">
                        <div class="rule" id="rule-length"><span class="rule-icon">✗</span><span>Minimal 8 karakter</span></div>
                        <div class="rule" id="rule-upper"><span class="rule-icon">✗</span><span>Minimal 1 huruf kapital (A-Z)</span></div>
                        <div class="rule" id="rule-number"><span class="rule-icon">✗</span><span>Minimal 1 angka (0-9)</span></div>
                        <div class="rule" id="rule-special"><span class="rule-icon">✗</span><span>Minimal 1 karakter spesial (!@#$...)</span></div>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="label-required">Konfirmasi Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            class="pw-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            required autocomplete="new-password">
                        <button type="button" class="toggle-password"
                            onclick="togglePw('password_confirmation','eye-conf','eyeoff-conf')"
                            title="Tampilkan">
                            <svg id="eye-conf" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeoff-conf" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mismatch-msg" id="mismatch-msg">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Kata sandi tidak cocok
                    </div>
                    <div class="match-msg" id="match-msg">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Kata sandi cocok
                    </div>
                    @error('password_confirmation')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Daftar --}}
                <button type="submit" class="btn-submit">Buat Akun</button>

            </div>
        </form>

        <p class="login-text">
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        </p>

    </div>
</div>

<script>
    // ── Toggle show/hide password ──
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

    // ── Validasi password real-time ──
    const passwordInput = document.getElementById('password');
    const confirmInput  = document.getElementById('password_confirmation');
    const rulesBox      = document.getElementById('password-rules');
    const mismatchMsg   = document.getElementById('mismatch-msg');
    const matchMsg      = document.getElementById('match-msg');

    let hideRulesTimer = null;

    passwordInput.addEventListener('input', function () {
        const val = this.value;

        const checks = {
            'rule-length':  val.length >= 8,
            'rule-upper':   /[A-Z]/.test(val),
            'rule-number':  /[0-9]/.test(val),
            'rule-special': /[!@#$%^&*(),.?":{}|<>]/.test(val),
        };

        Object.entries(checks).forEach(([id, valid]) => updateRule(id, valid));

        const allValid = Object.values(checks).every(Boolean);
        clearTimeout(hideRulesTimer);

        if (val.length === 0) {
            rulesBox.classList.remove('show');
        } else if (allValid) {
            hideRulesTimer = setTimeout(() => rulesBox.classList.remove('show'), 700);
        } else {
            rulesBox.classList.add('show');
        }

        if (confirmInput.value.length > 0) checkMatch();
    });

    confirmInput.addEventListener('input', checkMatch);

    function checkMatch() {
        const pw   = passwordInput.value;
        const conf = confirmInput.value;

        if (conf.length === 0) {
            mismatchMsg.classList.remove('show');
            matchMsg.classList.remove('show');
            return;
        }

        if (pw === conf) {
            mismatchMsg.classList.remove('show');
            matchMsg.classList.add('show');
        } else {
            matchMsg.classList.remove('show');
            mismatchMsg.classList.add('show');
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
            icon.textContent = '✗';
        }
    }

    // ── Hanya izinkan angka di NIK & No. Telp ──
    document.getElementById('nik').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });

    document.getElementById('no_telp').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 13);
    });
</script>

</body>
</html>
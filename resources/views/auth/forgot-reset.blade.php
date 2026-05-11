<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link rel="stylesheet" href="{{ asset('css/forgot.css') }}">
</head>
<body>

<div class="card">

    <div class="logo-corner">
        <img src="{{ asset('image/logo.png') }}"
             width="50"
             height="50">
    </div>

    <div class="left"></div>

    <div class="right">

        <h1>Buat Password Baru</h1>

        <p class="subtitle">
            Gunakan password baru untuk akunmu.
        </p>
        
        <form method="POST" action="/reset-password">

            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group">

                <label>Kata sandi baru</label>

                <div class="pw-wrap">

                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required>

                    <button type="button"
                        class="toggle-btn"
                        onclick="togglePw('password','eye1','eyeoff1')">

                        <svg id="eye1"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>

                        </svg>

                        <svg id="eyeoff1"
                            style="display:none"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

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
                        <span>Minimal 1 huruf kapital</span>
                    </div>

                    <div class="rule" id="rule-number">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 1 angka</span>
                    </div>

                    <div class="rule" id="rule-special">
                        <span class="rule-icon">✗</span>
                        <span>Minimal 1 karakter spesial</span>
                    </div>

                </div>

            </div>

            <div class="form-group">

                <label>Konfirmasi kata sandi</label>

                <div class="pw-wrap">

                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required>

                </div>

                <div class="mismatch-msg" id="mismatch-msg">
                    Kata sandi tidak cocok
                </div>

            </div>

            <button type="submit" class="btn-submit">
                Simpan kata sandi baru
            </button>

        </form>

    </div>

</div>

<script>

function togglePw(inputId, eyeId, eyeOffId){

    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    const eyeOff = document.getElementById(eyeOffId);

    if(input.type === 'password'){

        input.type = 'text';
        eye.style.display = 'none';
        eyeOff.style.display = 'block';

    }else{

        input.type = 'password';
        eye.style.display = 'block';
        eyeOff.style.display = 'none';
    }
}

const passwordInput = document.getElementById('password');
const confInput = document.getElementById('password_confirmation');
const rulesBox = document.getElementById('password-rules');
const mismatchMsg = document.getElementById('mismatch-msg');

passwordInput.addEventListener('input', function(){

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

    updateRule('rule-length', checks[0]);
    updateRule('rule-upper', checks[1]);
    updateRule('rule-number', checks[2]);
    updateRule('rule-special', checks[3]);

    checkMatch();
});

confInput.addEventListener('input', checkMatch);

function checkMatch(){

    if(confInput.value.length === 0){

        mismatchMsg.classList.remove('show');
        return;
    }

    if(passwordInput.value !== confInput.value){

        mismatchMsg.classList.add('show');

    }else{

        mismatchMsg.classList.remove('show');
    }
}

function updateRule(id, valid){

    const el = document.getElementById(id);
    const icon = el.querySelector('.rule-icon');

    if(valid){

        el.classList.add('valid');
        icon.textContent = '✓';

    }else{

        el.classList.remove('valid');
        icon.textContent = '✗';
    }
}

</script>

</body>
</html>
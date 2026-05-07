
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

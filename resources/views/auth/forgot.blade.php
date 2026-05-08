<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

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

        <h1>Lupa kata sandi?</h1>

        <p class="subtitle">
            Masukkan email akunmu terlebih dahulu.
        </p>

        <form method="POST" action="/forgot-password/check">

            @csrf

            <div class="form-group">

                <label>Email</label>

                <input type="email"
                    name="email"
                    placeholder="user@email.com"
                    value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    required>

                @error('email')
                    <span class="error-msg">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <button type="submit" class="btn-submit">
                Lanjut
            </button>

        </form>

        <a href="/auth/login" class="back-link">

            <svg width="14" height="14"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">

                <path d="M19 12H5M12 19l-7-7 7-7"/>

            </svg>

            Kembali ke halaman login

        </a>

    </div>

</div>

</body>
</html>
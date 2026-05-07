<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot</title>
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

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.10);
            width: 440px;
            max-width: 95vw;
            padding: 48px 44px;
        }

        .icon-wrap {
            width: 56px;
            height: 56px;
            background: #e6f7f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a2e3b;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #8a9bb0;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: #2d3e50;
            margin-bottom: 6px;
        }

        input[type="email"] {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #dde4ec;
            border-radius: 9px;
            font-size: 0.95rem;
            color: #2d3e50;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus { border-color: #2dc98a; background: #fff; }
        input::placeholder { color: #b5c3cf; }
        input.is-invalid { border-color: #e53935; }

        .error-msg {
            color: #e53935;
            font-size: 0.80rem;
            margin-top: 5px;
            display: block;
        }

        .alert-success {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            border-radius: 9px;
            padding: 12px 14px;
            font-size: 0.87rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, #2dc98a 0%, #1aaf74 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 18px;
            transition: box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(45,201,138,0.18);
        }
        .btn:hover { box-shadow: 0 6px 18px rgba(45,201,138,0.30); }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 0.88rem;
            color: #8a9bb0;
            text-decoration: none;
        }
        .back-link:hover { color: #2dc98a; }
    </style>
</head>
<body>

<div class="card">

    <div class="icon-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
            stroke="#2dc98a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
    </div>

    <h1>Lupa Kata Sandi?</h1>
    <p class="subtitle">
        Masukkan email kamu dan kami akan mengirimkan link untuk mereset kata sandi.
    </p>

    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="/forgot-password">
        @csrf

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                placeholder="user@email.com"
                value="{{ old('email') }}"
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                required autofocus>
            @error('email')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Kirim Link Reset</button>
    </form>

    <a href="/login" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Kembali ke halaman login
    </a>

</div>

</body>
</html>
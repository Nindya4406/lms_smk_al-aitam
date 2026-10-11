
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LMS SMK Plus Al-Aitaam</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1e293b;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            padding: 36px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(30, 64, 175, .12);
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #2563eb;
            color: white;
            font-size: 27px;
            font-weight: bold;
        }

        h1 {
            margin: 0;
            text-align: center;
            font-size: 25px;
        }

        .subtitle {
            margin: 10px 0 28px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        label {
            display: block;
            margin: 17px 0 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px #dbeafe;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 17px 0 22px;
            font-size: 14px;
            color: #475569;
        }

        .remember label {
            margin: 0;
            font-weight: normal;
        }

        button {
            width: 100%;
            padding: 14px;
            border: 0;
            border-radius: 10px;
            background: #2563eb;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .message {
            margin-bottom: 16px;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
        }

        .error {
            background: #fef2f2;
            color: #b91c1c;
        }

        .success {
            background: #f0fdf4;
            color: #166534;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="logo">A</div>

        <h1>Selamat Datang</h1>

        <p class="subtitle">
            LMS SMK Plus Al-Aitaam<br>
            Masuk untuk melanjutkan aktivitas pembelajaran.
        </p>

        @if (session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            >

            <div class="remember">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="1"
                >
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit">Masuk ke LMS</button>
        </form>

        <div class="footer">
            &copy; {{ date('Y') }} LMS SMK Plus Al-Aitaam
        </div>
    </main>
</body>
</html>

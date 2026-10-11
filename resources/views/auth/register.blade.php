<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi Siswa | LMS Al-Aitaam</title>

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
            background: #f1f5f9;
            font-family: Arial, sans-serif;
            color: #172033;
        }

        .card {
            width: 100%;
            max-width: 440px;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .subtitle {
            margin: 0 0 24px;
            color: #64748b;
            line-height: 1.6;
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 15px;
        }

        input:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 9px;
            background: #2563eb;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .notice {
            margin-bottom: 18px;
            padding: 12px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 14px;
            line-height: 1.5;
        }

        .errors {
            margin-bottom: 16px;
            padding: 12px 12px 12px 30px;
            border-radius: 8px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }

        .footer {
            margin-top: 22px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Registrasi Siswa</h1>

        <p class="subtitle">
            Buat akun untuk menggunakan LMS SMK Plus Al-Aitaam.
        </p>

        <div class="notice">
            Formulir ini hanya untuk siswa. Akun Guru dibuat oleh Admin sekolah.
        </div>

        @if ($errors->any())
            <ul class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('register.process') }}">
            @csrf

            <label for="name">Nama lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                maxlength="255"
                autocomplete="name"
                required
                autofocus
            >

            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                maxlength="255"
                autocomplete="email"
                required
            >

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                minlength="8"
                autocomplete="new-password"
                required
            >

            <label for="password_confirmation">
                Konfirmasi password
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                minlength="8"
                autocomplete="new-password"
                required
            >

            <button type="submit">Buat Akun Siswa</button>
        </form>

        <div class="footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </main>
</body>
</html>

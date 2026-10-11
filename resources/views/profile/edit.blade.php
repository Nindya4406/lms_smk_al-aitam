
@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('breadcrumb', 'Pengaturan Akun')

@section('content')
    <style>
        .profile-page {
            max-width: 1100px;
            margin: 0 auto;
        }

        .profile-intro {
            margin-bottom: 24px;
        }

        .profile-intro h2 {
            margin: 0 0 7px;
            color: #172554;
            font-size: 22px;
            font-weight: 750;
        }

        .profile-intro p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .profile-hero {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 30px;
            margin-bottom: 24px;
            background: linear-gradient(120deg, #1d4ed8, #2563eb 60%, #3b82f6);
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(37, 99, 235, .16);
        }

        .profile-hero::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            right: -70px;
            top: -130px;
            border: 35px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        .profile-hero::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            right: 120px;
            bottom: -125px;
            background: rgba(255, 255, 255, .07);
            border-radius: 50%;
        }

        .profile-avatar {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 88px;
            height: 88px;
            border: 4px solid rgba(255, 255, 255, .35);
            border-radius: 24px;
            background: #fff;
            color: #1d4ed8;
            font-size: 30px;
            font-weight: 800;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .12);
        }

        .profile-hero-info {
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .profile-hero-info h2 {
            margin: 0 0 7px;
            color: #fff;
            font-size: 23px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .profile-hero-info p {
            margin: 0 0 13px;
            color: #dbeafe;
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .profile-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 30px;
            background: rgba(255, 255, 255, .13);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(300px, .8fr);
            align-items: start;
            gap: 22px;
        }

        .profile-card {
            min-width: 0;
            padding: 25px;
            background: #fff;
            border: 1px solid #e6ebf2;
            border-radius: 17px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
        }

        .profile-card-header {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding-bottom: 20px;
            margin-bottom: 21px;
            border-bottom: 1px solid #edf2f7;
        }

        .profile-card-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 20px;
        }

        .profile-card-header h3 {
            margin: 0 0 5px;
            color: #172554;
            font-size: 16px;
            font-weight: 750;
        }

        .profile-card-header p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.7;
        }

        .profile-field {
            margin-bottom: 19px;
        }

        .profile-field label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 13px;
            font-weight: 650;
        }

        .profile-field input {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 12px 14px;
            border: 1px solid #dbe3ee;
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: #1e293b;
            font-family: inherit;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        .profile-field input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
        }

        .profile-field input::placeholder {
            color: #a0aec0;
        }

        .profile-field small {
            display: block;
            margin-top: 7px;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.6;
        }

        .profile-field-error {
            display: block;
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
        }

        .profile-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 43px;
            padding: 11px 17px;
            border: 0;
            border-radius: 10px;
            background: #2563eb;
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .profile-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .profile-button-secondary {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .profile-button-secondary:hover {
            background: #e2e8f0;
        }

        .profile-form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 5px;
        }

        .profile-message {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.7;
        }

        .profile-message-success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .profile-message-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .profile-side-info {
            margin-top: 22px;
            padding: 20px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: #eff6ff;
        }

        .profile-side-info h4 {
            margin: 0 0 8px;
            color: #1e40af;
            font-size: 14px;
        }

        .profile-side-info p {
            margin: 0;
            color: #475569;
            font-size: 12px;
            line-height: 1.8;
        }

        .profile-meta {
            display: grid;
            gap: 15px;
            margin-top: 20px;
        }

        .profile-meta-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding-bottom: 13px;
            border-bottom: 1px solid #edf2f7;
        }

        .profile-meta-item:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .profile-meta-label {
            color: #64748b;
            font-size: 12px;
        }

        .profile-meta-value {
            color: #334155;
            font-size: 12px;
            font-weight: 650;
            text-align: right;
            overflow-wrap: anywhere;
        }

        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 560px) {
            .profile-hero {
                align-items: flex-start;
                flex-direction: column;
                gap: 17px;
                padding: 23px;
            }

            .profile-avatar {
                width: 72px;
                height: 72px;
                border-radius: 20px;
                font-size: 25px;
            }

            .profile-hero-info h2 {
                font-size: 20px;
            }

            .profile-card {
                padding: 20px;
            }

            .profile-form-actions {
                flex-direction: column;
            }

            .profile-button {
                width: 100%;
            }
        }
    </style>

    @php
        $displayName = trim($user->name ?? '');
        $nameParts = preg_split('/\s+/', $displayName, -1, PREG_SPLIT_NO_EMPTY);
        $initials = '';

        if (count($nameParts) > 0) {
            $initials = mb_substr($nameParts[0], 0, 1);

            if (count($nameParts) > 1) {
                $initials .= mb_substr($nameParts[count($nameParts) - 1], 0, 1);
            }
        }

        $initials = mb_strtoupper($initials ?: 'U');
    @endphp

    <div class="profile-page">
        <div class="profile-intro">
            <h2>Profil Saya</h2>
            <p>
                Kelola informasi pribadi dan keamanan akun
                LMS SMK Plus Al-Aitaam.
            </p>
        </div>

        @if (session('success'))
            <div class="profile-message profile-message-success">
                <span>✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-message profile-message-error">
                <span>!</span>
                <div>
                    <strong>Periksa kembali data yang dimasukkan.</strong>

                    <ul style="margin: 7px 0 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="profile-hero">
            <div class="profile-avatar">
                {{ $initials }}
            </div>

            <div class="profile-hero-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>

                <div class="profile-badges">
                    <span class="profile-badge">
                        ✓ {{ ucfirst($user->role) }}
                    </span>

                    <span class="profile-badge">
                        Akun LMS
                    </span>
                </div>
            </div>
        </section>

        <div class="profile-grid">
            <section class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-icon">♙</div>

                    <div>
                        <h3>Informasi Akun</h3>
                        <p>
                            Perbarui nama dan alamat email akun kamu.
                        </p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="profile-field">
                        <label for="name">Nama lengkap</label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            maxlength="255"
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                        @error('name')
                            <span class="profile-field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="email">Alamat email</label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            maxlength="255"
                            autocomplete="email"
                            placeholder="nama@email.com"
                            required
                        >

                        <small>
                            Gunakan email yang aktif dan dapat kamu akses.
                        </small>

                        @error('email')
                            <span class="profile-field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="profile-form-actions">
                        <button type="submit" class="profile-button">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <div class="profile-side-info">
                    <h4>Jaga informasi akun kamu</h4>
                    <p>
                        Pastikan nama dan email selalu benar agar
                        informasi akun di dalam sistem LMS tetap sesuai.
                    </p>
                </div>
            </section>

            <div>
                <section class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-card-icon">♢</div>

                        <div>
                            <h3>Keamanan Password</h3>
                            <p>
                                Gunakan password baru untuk menjaga
                                keamanan akun.
                            </p>
                        </div>
                    </div>

                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="profile-field">
                            <label for="current_password">
                                Password saat ini
                            </label>

                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Masukkan password saat ini"
                                required
                            >

                            @error('current_password')
                                <span class="profile-field-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="password">
                                Password baru
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                minlength="8"
                                placeholder="Minimal 8 karakter"
                                required
                            >

                            @error('password')
                                <span class="profile-field-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="password_confirmation">
                                Konfirmasi password baru
                            </label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                minlength="8"
                                placeholder="Ulangi password baru"
                                required
                            >
                        </div>

                        <div class="profile-form-actions">
                            <button type="submit" class="profile-button">
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </section>

                <section class="profile-card" style="margin-top: 22px;">
                    <div class="profile-card-header">
                        <div class="profile-card-icon">▤</div>

                        <div>
                            <h3>Ringkasan Akun</h3>
                            <p>
                                Informasi dasar akun yang sedang digunakan.
                            </p>
                        </div>
                    </div>

                    <div class="profile-meta">
                        <div class="profile-meta-item">
                            <span class="profile-meta-label">
                                Nama
                            </span>

                            <span class="profile-meta-value">
                                {{ $user->name }}
                            </span>
                        </div>

                        <div class="profile-meta-item">
                            <span class="profile-meta-label">
                                Role
                            </span>

                            <span class="profile-meta-value">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="profile-meta-item">
                            <span class="profile-meta-label">
                                Email
                            </span>

                            <span class="profile-meta-value">
                                {{ $user->email }}
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

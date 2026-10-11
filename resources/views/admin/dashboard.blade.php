@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('breadcrumb', 'Dashboard')

@section('content')
    <style>
        .dashboard-welcome {
            margin-bottom: 28px;
        }

        .dashboard-welcome h2 {
            margin: 0 0 8px;
            color: #172554;
            font-size: 22px;
            font-weight: 750;
        }

        .dashboard-welcome p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .stat-card {
            position: relative;
            display: block;
            overflow: hidden;
            padding: 24px;
            background: #fff;
            border: 1px solid #e6ebf2;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
            text-decoration: none;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .07);
        }

        .stat-card:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 3px;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            right: -25px;
            top: -30px;
            width: 95px;
            height: 95px;
            border-radius: 50%;
            background: #eff6ff;
            pointer-events: none;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 20px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .stat-number {
            position: relative;
            z-index: 1;
            margin-top: 18px;
            color: #172554;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-description {
            position: relative;
            z-index: 1;
            margin-top: 7px;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 1000px) {
            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 20px;
            }

            .dashboard-welcome h2 {
                font-size: 20px;
            }
        }
    </style>

    <div class="dashboard-welcome">
        <h2>
            Halo, {{ auth()->user()->name }}!
        </h2>

        <p>
            Selamat datang di LMS SMK Plus Al-Aitaam.
            Berikut ringkasan data akademik sekolah saat ini.
        </p>
    </div>

    <div class="dashboard-stats">

        {{-- Total Siswa --}}
        <a href="{{ route('admin.users.index') }}"
           class="stat-card"
           aria-label="Lihat manajemen pengguna untuk data siswa">
            <div class="stat-top">
                <div class="stat-label">Total Siswa</div>
                <div class="stat-icon">♙</div>
            </div>

            <div class="stat-number">
                {{ $jumlahSiswa }}
            </div>

            <div class="stat-description">
                Akun siswa terdaftar
            </div>
        </a>

        {{-- Total Guru --}}
        <a href="{{ route('admin.users.index') }}"
           class="stat-card"
           aria-label="Lihat manajemen pengguna untuk data guru">
            <div class="stat-top">
                <div class="stat-label">Total Guru</div>
                <div class="stat-icon">♧</div>
            </div>

            <div class="stat-number">
                {{ $jumlahGuru }}
            </div>

            <div class="stat-description">
                Akun guru terdaftar
            </div>
        </a>

        {{-- Total Jurusan --}}
        <a href="{{ route('admin.jurusan.index') }}"
           class="stat-card"
           aria-label="Lihat data jurusan">
            <div class="stat-top">
                <div class="stat-label">Total Jurusan</div>
                <div class="stat-icon">⌘</div>
            </div>

            <div class="stat-number">
                {{ $jumlahJurusan }}
            </div>

            <div class="stat-description">
                Program keahlian sekolah
            </div>
        </a>

        {{-- Total Kelas --}}
        <a href="{{ route('admin.kelas.index') }}"
           class="stat-card"
           aria-label="Lihat data kelas">
            <div class="stat-top">
                <div class="stat-label">Total Kelas</div>
                <div class="stat-icon">▤</div>
            </div>

            <div class="stat-number">
                {{ $jumlahKelas }}
            </div>

            <div class="stat-description">
                Kelas yang telah dibuat
            </div>
        </a>

        {{-- Total Mata Pelajaran --}}
        <a href="{{ route('admin.mata-pelajaran.index') }}"
           class="stat-card"
           aria-label="Lihat data mata pelajaran">
            <div class="stat-top">
                <div class="stat-label">Mata Pelajaran</div>
                <div class="stat-icon">▣</div>
            </div>

            <div class="stat-number">
                {{ $jumlahMataPelajaran }}
            </div>

            <div class="stat-description">
                Mata pelajaran terdaftar
            </div>
        </a>

    </div>
@endsection

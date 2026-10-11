
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Admin') - LMS Al-Aitaam</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #142b4a;
            --navy-dark: #0e2038;
            --blue: #2563eb;
            --blue-light: #eff6ff;
            --background: #f5f7fb;
            --white: #ffffff;
            --text: #172b4d;
            --muted: #718096;
            --border: #e5eaf1;
            --danger: #dc2626;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            font-size: 14px;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        .app {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            width: var(--sidebar-width);
            background: var(--navy);
            color: #d9e4f3;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 25px 21px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .brand-logo {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #ffffff;
            color: var(--navy);
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
        }

        .brand-name {
            color: white;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .3px;
            line-height: 1.5;
        }

        .brand-subtitle {
            color: #a8bdd8;
            font-size: 10px;
            margin-top: 3px;
        }

        .sidebar-content {
            padding: 22px 14px;
            flex: 1;
        }

        .menu-label {
            color: #8fa6c4;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            padding: 0 12px;
            margin: 7px 0 12px;
            text-transform: uppercase;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 45px;
            padding: 11px 13px;
            margin-bottom: 5px;
            border-radius: 9px;
            color: #d0dced;
            font-size: 12px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--blue);
            color: white;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0,0,0,.12);
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.1);
            padding: 17px 14px;
        }

        .sidebar-footer .sidebar-link {
            margin-bottom: 0;
        }

        .sidebar-link.logout-link:hover {
            background: rgba(220,38,38,.18);
            color: #fecaca;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            min-height: 76px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 32px;
            gap: 20px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-heading {
            font-size: 17px;
            font-weight: 800;
            color: var(--text);
        }

        .page-subheading {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
        }

        .user-role {
            color: var(--muted);
            font-size: 10px;
            margin-top: 4px;
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--blue-light);
            color: var(--blue);
            font-weight: 800;
            font-size: 14px;
        }

        .mobile-menu {
            display: none;
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: white;
            color: var(--navy);
            cursor: pointer;
            font-size: 20px;
        }

        .content {
            padding: 30px 32px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* FLASH MESSAGES */
        .alert {
            padding: 14px 17px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.6;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .field-errors {
            margin-top: 6px;
            color: var(--danger);
            font-size: 12px;
        }

        /* GENERAL CONTENT COMPONENTS */
        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 23px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .025);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 800;
        }

        .card-description {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: var(--blue);
            color: white;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover {
            filter: brightness(.94);
        }

        .btn-secondary {
            color: #334155;
            background: white;
            border-color: var(--border);
        }

        .btn-danger {
            background: #dc2626;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 13px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            vertical-align: middle;
        }

        th {
            color: #64748b;
            background: #f8fafc;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 800;
        }

        td {
            color: #334155;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            min-height: 42px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            padding: 10px 12px;
            color: #1e293b;
            background: white;
            outline: none;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .empty-state {
            padding: 35px 15px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        .sidebar-overlay {
            display: none;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 900;
                background: rgba(15,23,42,.45);
            }

            .main {
                margin-left: 0;
            }

            .mobile-menu {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 14px 20px;
            }

            .content {
                padding: 22px 20px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                padding: 13px 14px;
            }

            .content {
                padding: 18px 14px;
            }

            .page-heading {
                font-size: 14px;
            }

            .page-subheading {
                display: none;
            }

            .user-info {
                display: none;
            }

            .card {
                padding: 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="app">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">AA</div>
            <div>
                <div class="brand-name">SMK PLUS AL-AITAAM</div>
                <div class="brand-subtitle">Learning Management System</div>
            </div>
        </div>

        <nav class="sidebar-content">
            <div class="menu-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">▦</span>
                <span>Dashboard</span>
            </a>

            <div class="menu-label" style="margin-top: 25px;">Manajemen Data</div>

            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="menu-icon">♙</span>
                <span>Data Pengguna</span>
            </a>

            <a href="{{ route('admin.jurusan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
                <span class="menu-icon">▤</span>
                <span>Data Jurusan</span>
            </a>

            <a href="{{ route('admin.kelas.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <span class="menu-icon">▥</span>
                <span>Data Kelas</span>
            </a>

            {{-- FIX: Gunakan nama route yang benar, bukan wildcard --}}
            <a href="{{ route('admin.mata-pelajaran.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
                <span class="menu-icon">▧</span>
                <span>Mata Pelajaran</span>
            </a>

            <a href="{{ route('admin.penugasan-guru.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.penugasan-guru.*') ? 'active' : '' }}">
                <span class="menu-icon">♧</span>
                <span>Penugasan Guru</span>
            </a>

            <a href="{{ route('admin.pengumuman.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <span class="menu-icon">♢</span>
                <span>Pengumuman</span>
            </a>

            <div class="menu-label" style="margin-top: 25px;">Akun</div>

            <a href="{{ route('profile.edit') }}"
               class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="menu-icon">⚙</span>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="sidebar-link logout-link"
                        style="width:100%;border:0;background:transparent;text-align:left;cursor:pointer;">
                    <span class="menu-icon">↪</span>
                    <span>Keluar dari Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- MAIN --}}
    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button"
                        class="mobile-menu"
                        id="mobileMenu"
                        aria-label="Buka menu navigasi">
                    ☰
                </button>

                <div>
                    <div class="page-heading">@yield('page-title', 'Dashboard Admin')</div>
                    <div class="page-subheading">
                        Sistem Informasi Pembelajaran SMK Plus Al-Aitaam
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">Administrator</div>
                </div>

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <section class="content">

            @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin:8px 0 0 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuButton = document.getElementById('mobileMenu');

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }

        menuButton.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function () {
            if (window.innerWidth > 900) {
                closeSidebar();
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>

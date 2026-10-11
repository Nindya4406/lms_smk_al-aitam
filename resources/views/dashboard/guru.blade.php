
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru | LMS Al-Aitaam</title>
    <style>
        body {
            margin: 0;
            padding: 32px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .card {
            max-width: 850px;
            margin: 30px auto;
            padding: 32px;
            background: white;
            border-radius: 18px;
        }

        button {
            padding: 12px 18px;
            border: 0;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Dashboard Guru</h1>
        <p>Halo, {{ auth()->user()->name }}!</p>
        <p>Selamat datang di LMS SMK Plus Al-Aitaam.</p>
        <p>
            Halaman ini nantinya memuat materi, tugas, presensi,
            penilaian, dan fitur wali kelas.
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </main>
</body>
</html>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penugasan Guru | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
<main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

    <a
        href="{{ route('admin.penugasan-guru.index') }}"
        class="text-sm font-semibold text-blue-600 hover:text-blue-700"
    >
        ← Kembali ke Penugasan Guru
    </a>

    <div class="mb-8 mt-6">
        <p class="mb-2 text-sm font-semibold text-blue-600">
            ADMINISTRATOR / PENUGASAN GURU
        </p>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Tambah Penugasan Guru
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Tentukan Guru, kelas, dan mata pelajaran yang akan diajar.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Periksa kembali data berikut:</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('admin.penugasan-guru.store') }}" method="POST">
            @include('admin.penugasan-guru._form', [
                'penugasanGuru' => null,
                'tombolSimpan' => 'Simpan Penugasan',
            ])
        </form>
    </section>

</main>
</body>
</html>

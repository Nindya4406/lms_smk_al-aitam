
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jurusan | LMS Al-Aitaam</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:py-12">

        <a
            href="{{ route('admin.jurusan.index') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-800"
        >
            <span aria-hidden="true">&larr;</span>
            Kembali ke Data Jurusan
        </a>

        <div class="mb-6">
            <p class="mb-2 text-sm font-semibold text-blue-600">
                DATA MASTER
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Edit Jurusan
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Perbarui informasi jurusan sesuai data terbaru.
            </p>
        </div>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">

            <div class="mb-6 border-b border-slate-100 pb-5">
                <h2 class="font-bold text-slate-900">
                    Informasi Jurusan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Jurusan yang sedang diedit:
                    <span class="font-semibold text-slate-700">
                        {{ $jurusan->nama_jurusan }}
                    </span>
                </p>
            </div>

            @php
                $action = route('admin.jurusan.update', $jurusan);
                $httpMethod = 'PUT';
                $buttonLabel = 'Simpan Perubahan';
            @endphp

            @include('admin.jurusan._form')

        </section>

        <p class="mt-6 text-center text-xs text-slate-400">
            LMS SMK Plus Al-Aitaam
        </p>

    </main>

</body>
</html>

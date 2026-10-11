
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengumuman | LMS Al-Aitaam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <main class="mx-auto max-w-3xl p-6 lg:p-10">
        <a href="{{ route('admin.pengumuman.index') }}"
           class="text-sm font-semibold text-blue-600 hover:underline">
            ← Kembali ke Pengumuman
        </a>

        <div class="mb-7 mt-5">
            <p class="text-sm font-semibold text-blue-600">MANAJEMEN SEKOLAH</p>
            <h1 class="mt-2 text-3xl font-bold">Buat Pengumuman</h1>
            <p class="mt-2 text-slate-500">
                Buat informasi untuk seluruh sekolah atau kelas tertentu.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengumuman.store') }}"
              method="POST"
              class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @include('admin.pengumuman._form')
        </form>
    </main>
</body>
</html>

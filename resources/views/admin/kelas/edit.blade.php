
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<main class="mx-auto max-w-3xl px-4 py-8 sm:px-6">

    <a
        href="{{ route('admin.kelas.index') }}"
        class="text-sm font-semibold text-blue-600 hover:text-blue-800"
    >
        ← Kembali ke Data Kelas
    </a>

    <div class="mb-6 mt-5">
        <p class="text-sm font-semibold text-blue-600">DATA MASTER</p>
        <h1 class="mt-1 text-3xl font-bold">Edit Kelas</h1>
        <p class="mt-2 text-sm text-slate-500">
            Perbarui data kelas {{ $kelas->nama_kelas }}.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.kelas.update', ['kelas' => $kelas->id]) }}"
        method="POST"
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
    >
        @csrf
        @method('PUT')

        @include('admin.kelas._form', [
            'buttonLabel' => 'Simpan Perubahan'
        ])
    </form>

</main>

</body>
</html>

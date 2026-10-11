
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan Guru | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="mb-2 text-sm font-semibold text-blue-600">
                ADMINISTRATOR / AKADEMIK
            </p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Penugasan Guru
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Kelola pembagian mengajar dan penunjukan wali kelas.
            </p>
        </div>

        <a
            href="{{ route('admin.penugasan-guru.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
        >
            + Tambah Penugasan
        </a>
    </div>

    @if (session('success'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Ada data yang perlu diperbaiki:</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- BAGIAN 1: PENGATURAN WALI KELAS --}}
    <section class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900">
                Pengaturan Wali Kelas
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Setiap kelas dapat memiliki satu wali kelas. Guru hanya dapat menjadi wali untuk satu kelas pada satu waktu.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kelas</th>
                        <th class="px-6 py-4 font-semibold">Jurusan</th>
                        <th class="px-6 py-4 font-semibold">Wali Kelas Saat Ini</th>
                        <th class="px-6 py-4 font-semibold">Pilih Wali Kelas</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($kelasList as $kelas)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $kelas->nama_kelas }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Tingkat {{ $kelas->tingkat }}
                                    · {{ $kelas->tahun_ajaran }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $kelas->jurusan?->nama_jurusan ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($kelas->waliKelas)
                                    <p class="font-medium text-slate-800">
                                        {{ $kelas->waliKelas->name }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $kelas->waliKelas->email }}
                                    </p>
                                @else
                                    <span class="text-sm text-slate-400">
                                        Belum ditentukan
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <form
                                    action="{{ route('admin.penugasan-guru.wali-kelas') }}"
                                    method="POST"
                                    class="flex min-w-[330px] gap-2"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="kelas_id"
                                        value="{{ $kelas->id }}"
                                    >

                                    <select
                                        name="guru_id"
                                        required
                                        class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
                                    >
                                        <option value="">Pilih Guru</option>

                                        @foreach ($guruList as $guru)
                                            <option
                                                value="{{ $guru->id }}"
                                                @selected((string) old('kelas_id') === (string) $kelas->id && (string) old('guru_id') === (string) $guru->id)
                                                @selected(!old('kelas_id') && $kelas->wali_kelas_id == $guru->id)
                                            >
                                                {{ $guru->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                    >
                                        Simpan
                                    </button>
                                </form>

                                @if ($kelas->wali_kelas_id)
                                    <form
                                        action="{{ route('admin.penugasan-guru.wali-kelas') }}"
                                        method="POST"
                                        class="mt-2"
                                        onsubmit="return confirm('Kosongkan penunjukan wali kelas ini?')"
                                    >
                                        @csrf
                                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                        <input type="hidden" name="guru_id" value="">

                                        <button
                                            type="submit"
                                            class="text-xs font-medium text-red-600 hover:text-red-700"
                                        >
                                            Hapus penunjukan wali kelas
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                Belum ada kelas. Tambahkan data kelas terlebih dahulu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- BAGIAN 2: DAFTAR PENUGASAN MENGAJAR --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900">
                Daftar Penugasan Mengajar
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Daftar Guru, kelas, dan mata pelajaran yang telah ditetapkan.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No.</th>
                        <th class="px-6 py-4 font-semibold">Guru</th>
                        <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                        <th class="px-6 py-4 font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($penugasan as $index => $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">
                                {{ $penugasan->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $item->guru?->name ?? 'Guru tidak ditemukan' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $item->guru?->email ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">
                                    {{ $item->mataPelajaran?->nama_mapel ?? '-' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $item->mataPelajaran?->kode_mapel ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">
                                    {{ $item->kelas?->nama_kelas ?? '-' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $item->kelas?->jurusan?->nama_jurusan ?? '-' }}
                                    · {{ $item->kelas?->tahun_ajaran ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.penugasan-guru.edit', ['penugasanGuru' => $item->id]) }}"
                                        class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.penugasan-guru.destroy', ['penugasanGuru' => $item->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="font-semibold text-slate-700">
                                    Belum ada penugasan mengajar.
                                </p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Gunakan tombol Tambah Penugasan untuk memulai.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col justify-between gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <p class="text-sm text-slate-500">
                @if ($penugasan->total() > 0)
                    Menampilkan {{ $penugasan->firstItem() }}–{{ $penugasan->lastItem() }}
                    dari {{ $penugasan->total() }} penugasan
                @else
                    Belum ada data untuk ditampilkan
                @endif
            </p>

            <div>
                {{ $penugasan->links() }}
            </div>
        </div>
    </section>

</main>
</body>
</html>

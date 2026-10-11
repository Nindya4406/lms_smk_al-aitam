
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan | LMS Al-Aitaam</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header halaman --}}
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="mb-2 text-sm font-semibold text-blue-600">
                    ADMINISTRATOR / DATA MASTER
                </p>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Data Master Jurusan
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola program keahlian SMK Plus Al-Aitaam.
                </p>
            </div>

            <a
                href="{{ route('admin.jurusan.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                <span class="text-lg leading-none">+</span>
                Tambah Jurusan
            </a>
        </div>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div
                role="status"
                class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if (session('error'))
            <div
                role="alert"
                class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
            >
                {{ session('error') }}
            </div>
        @endif

        {{-- Ringkasan data --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-6 w-6"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Jurusan
                        </p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">
                            {{ $jurusan->total() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-6 w-6"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-6-6h12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Data di Halaman Ini
                        </p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">
                            {{ $jurusan->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel jurusan --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 p-5 sm:p-6">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-slate-900">
                        Daftar Jurusan
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Cari dan kelola data program keahlian.
                    </p>
                </div>

                <form
                    action="{{ route('admin.jurusan.index') }}"
                    method="GET"
                    class="flex flex-col gap-3 sm:flex-row"
                >
                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ $keyword }}"
                            placeholder="Cari nama atau kode jurusan..."
                            aria-label="Cari jurusan"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                        >
                    </div>

                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Cari
                    </button>

                    @if ($keyword)
                        <a
                            href="{{ route('admin.jurusan.index') }}"
                            class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[650px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">No.</th>
                            <th class="px-6 py-4 font-semibold">Kode Jurusan</th>
                            <th class="px-6 py-4 font-semibold">Nama Jurusan</th>
                            <th class="px-6 py-4 text-center font-semibold">Jumlah Kelas</th>
                            <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($jurusan as $index => $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $jurusan->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">
                                        {{ $item->kode_jurusan }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="font-semibold text-slate-800">
                                        {{ $item->nama_jurusan }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex min-w-8 justify-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $item->kelas_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('admin.jurusan.edit', $item) }}"
                                            class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.jurusan.destroy', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus jurusan {{ $item->nama_jurusan }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center">
                                    <p class="font-semibold text-slate-700">
                                        {{ $keyword ? 'Jurusan tidak ditemukan' : 'Belum ada data jurusan' }}
                                    </p>
                                    <p class="mt-2 text-sm text-slate-500">
                                        {{ $keyword ? 'Coba kata kunci lain.' : 'Tambahkan jurusan untuk mulai mengelola data.' }}
                                    </p>

                                    @if (! $keyword)
                                        <a
                                            href="{{ route('admin.jurusan.create') }}"
                                            class="mt-4 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                        >
                                            Tambah Jurusan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex flex-col justify-between gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
                <p class="text-sm text-slate-500">
                    @if ($jurusan->total() > 0)
                        Menampilkan {{ $jurusan->firstItem() }}–{{ $jurusan->lastItem() }}
                        dari {{ $jurusan->total() }} data
                    @else
                        Tidak ada data untuk ditampilkan
                    @endif
                </p>

                <div>
                    {{ $jurusan->links() }}
                </div>
            </div>
        </section>

        <p class="mt-6 text-center text-xs text-slate-400">
            LMS SMK Plus Al-Aitaam · Data Master Jurusan
        </p>

    </main>

</body>
</html>

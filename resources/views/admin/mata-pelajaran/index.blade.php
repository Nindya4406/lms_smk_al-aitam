
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="mb-2 text-sm font-semibold text-blue-600">
                ADMINISTRATOR / DATA MASTER
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Data Master Mata Pelajaran
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola daftar mata pelajaran SMK Plus Al-Aitaam.
            </p>
        </div>

        <a href="{{ route('admin.mata-pelajaran.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <span class="text-lg leading-none">+</span>
            Tambah Mata Pelajaran
        </a>
    </div>

    @if (session('success'))
        <div role="status"
             class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div role="alert"
             class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Mata Pelajaran
                    </p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">
                        {{ $totalMataPelajaran }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Data di Halaman Ini
                    </p>
                    <p class="mt-1 text-3xl font-bold text-slate-900">
                        {{ $mataPelajaran->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 p-5 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900">
                Daftar Mata Pelajaran
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Cari berdasarkan kode atau nama mata pelajaran.
            </p>

            <form action="{{ route('admin.mata-pelajaran.index') }}"
                  method="GET"
                  class="mt-4 flex flex-col gap-3 sm:flex-row">

                <input type="text"
                       name="search"
                       value="{{ $keyword }}"
                       placeholder="Cari kode atau nama mata pelajaran..."
                       aria-label="Cari mata pelajaran"
                       class="min-w-0 flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Cari
                </button>

                @if ($keyword)
                    <a href="{{ route('admin.mata-pelajaran.index') }}"
                       class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No.</th>
                        <th class="px-6 py-4 font-semibold">Kode Mapel</th>
                        <th class="px-6 py-4 font-semibold">Nama Mata Pelajaran</th>
                        <th class="px-6 py-4 font-semibold">Penugasan Guru</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($mataPelajaran as $index => $item)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">
                                {{ $mataPelajaran->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">
                                    {{ $item->kode_mapel }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $item->nama_mapel }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex min-w-8 justify-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    {{ $item->penugasan_guru_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.mata-pelajaran.edit', ['mataPelajaran' => $item->id]) }}"
                                       class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-50">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.mata-pelajaran.destroy', ['mataPelajaran' => $item->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus mata pelajaran {{ $item->nama_mapel }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">
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
                                    {{ $keyword ? 'Mata pelajaran tidak ditemukan' : 'Belum ada mata pelajaran' }}
                                </p>

                                <p class="mt-2 text-sm text-slate-500">
                                    {{ $keyword ? 'Coba kata kunci lain.' : 'Tambahkan mata pelajaran untuk mulai mengelola data.' }}
                                </p>

                                @if (! $keyword)
                                    <a href="{{ route('admin.mata-pelajaran.create') }}"
                                       class="mt-4 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                        Tambah Mata Pelajaran
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col justify-between gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <p class="text-sm text-slate-500">
                @if ($mataPelajaran->total() > 0)
                    Menampilkan {{ $mataPelajaran->firstItem() }}–{{ $mataPelajaran->lastItem() }}
                    dari {{ $mataPelajaran->total() }} data
                @else
                    Tidak ada data untuk ditampilkan
                @endif
            </p>

            <div>{{ $mataPelajaran->links() }}</div>
        </div>
    </section>

    <p class="mt-6 text-center text-xs text-slate-400">
        LMS SMK Plus Al-Aitaam · Data Master Mata Pelajaran
    </p>

</main>
</body>
</html>

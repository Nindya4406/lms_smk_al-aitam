
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-bold uppercase tracking-wider text-blue-600">
                DATA MASTER
            </p>
            <h1 class="mt-1 text-3xl font-bold">Data Kelas</h1>
            <p class="mt-2 text-sm text-slate-500">
                Kelola kelas, jurusan, tingkat, tahun ajaran, dan wali kelas.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('admin.dashboard') }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold hover:bg-slate-100"
            >
                Dashboard
            </a>

            <a
                href="{{ route('admin.kelas.create') }}"
                class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700"
            >
                + Tambah Kelas
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 p-5 sm:p-6">
            <form
                method="GET"
                action="{{ route('admin.kelas.index') }}"
                class="flex flex-col gap-3 sm:flex-row"
            >
                <input
                    type="search"
                    name="search"
                    value="{{ $keyword }}"
                    placeholder="Cari nama kelas, jurusan, tingkat, tahun ajaran..."
                    class="min-w-0 flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700"
                >
                    Cari
                </button>

                @if ($keyword !== '')
                    <a
                        href="{{ route('admin.kelas.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold hover:bg-slate-50"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Nama Kelas</th>
                        <th class="px-6 py-4">Jurusan</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Tahun Ajaran</th>
                        <th class="px-6 py-4">Wali Kelas</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($kelas as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">
                                {{ $kelas->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->jurusan?->nama_jurusan ?? 'Tidak tersedia' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="rounded-lg bg-blue-50 px-3 py-1 font-medium text-blue-700">
                                    {{ [10 => 'X', 11 => 'XI', 12 => 'XII'][(int) $item->tingkat] ?? $item->tingkat }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->tahun_ajaran }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->waliKelas?->name ?? 'Belum ditentukan' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.kelas.edit', ['kelas' => $item->id]) }}"
                                        class="rounded-lg border border-blue-200 px-3 py-2 font-medium text-blue-700 hover:bg-blue-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.kelas.destroy', ['kelas' => $item->id]) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus kelas ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-600 hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-14 text-center">
                                <p class="font-semibold text-slate-700">
                                    Belum ada data kelas
                                </p>
                                <p class="mt-1 text-slate-500">
                                    Klik Tambah Kelas untuk memasukkan data baru.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-6 py-4">
            {{ $kelas->links() }}
        </div>

    </section>
</main>

</body>
</html>

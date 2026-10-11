
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna | LMS Al-Aitaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="mb-2 text-sm font-semibold text-blue-600">ADMINISTRATOR / PENGGUNA</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Manajemen Pengguna
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Kelola akun Guru dan Siswa di LMS Al-Aitaam.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <span class="text-lg leading-none">+</span>
            Tambah Pengguna
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

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Guru</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalGuru }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Siswa</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalSiswa }}</p>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5 sm:p-6">
            <h2 class="text-lg font-bold text-slate-900">Daftar Pengguna</h2>

            <form action="{{ route('admin.users.index') }}" method="GET"
                  class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                <input
                    type="text"
                    name="search"
                    value="{{ $keyword }}"
                    placeholder="Cari nama atau email..."
                    class="min-w-0 rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                >

                <select name="role"
                        class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500">
                    <option value="">Semua Role</option>
                    <option value="guru" @selected($roleFilter === 'guru')>Guru</option>
                    <option value="siswa" @selected($roleFilter === 'siswa')>Siswa</option>
                </select>

                <select name="status"
                        class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected($statusFilter === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected($statusFilter === 'nonaktif')>Nonaktif</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Cari
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No.</th>
                        <th class="px-6 py-4 font-semibold">Nama</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $index => $item)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $item->name }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->email }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-lg px-3 py-1.5 text-xs font-semibold
                                    {{ $item->role === 'guru' ? 'bg-indigo-50 text-indigo-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ ucfirst($item->role) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold
                                    {{ $item->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', ['user' => $item->id]) }}"
                                       class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.users.destroy', ['user' => $item->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus akun {{ $item->name }}? Jika akun sudah terhubung dengan data sekolah, penghapusan dapat ditolak.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <p class="font-semibold text-slate-700">Belum ada pengguna yang cocok.</p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Tambahkan akun Guru atau Siswa, atau ubah kata kunci pencarian.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col justify-between gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <p class="text-sm text-slate-500">
                @if ($users->total() > 0)
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                    dari {{ $users->total() }} pengguna
                @else
                    Tidak ada data untuk ditampilkan
                @endif
            </p>
            <div>{{ $users->links() }}</div>
        </div>
    </section>
</main>
</body>
</html>

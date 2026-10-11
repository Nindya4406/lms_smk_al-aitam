
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman | LMS Al-Aitaam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <main class="mx-auto max-w-7xl p-6 lg:p-10">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-semibold text-blue-600">LMS AL-AITAAM</p>
                <h1 class="mt-2 text-3xl font-bold">Pengumuman Sekolah</h1>
                <p class="mt-2 text-slate-500">
                    Kelola informasi untuk sekolah dan kelas.
                </p>
            </div>

            <a href="{{ route('admin.pengumuman.create') }}"
               class="rounded-xl bg-blue-600 px-5 py-3 text-center font-semibold text-white hover:bg-blue-700">
                + Buat Pengumuman
            </a>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">
            <form method="GET" action="{{ route('admin.pengumuman.index') }}"
                  class="grid gap-4 md:grid-cols-3">
                <input type="text" name="cari"
                       value="{{ request('cari') }}"
                       placeholder="Cari judul atau isi pengumuman..."
                       class="rounded-xl border border-slate-300 px-4 py-3">

                <select name="status" class="rounded-xl border border-slate-300 px-4 py-3">
                    <option value="">Semua status</option>
                    <option value="draft" @selected(request('status') === 'draft')>
                        Draf
                    </option>
                    <option value="dipublikasikan"
                        @selected(request('status') === 'dipublikasikan')>
                        Dipublikasikan
                    </option>
                </select>

                <div class="flex gap-2">
                    <button class="flex-1 rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white">
                        Cari
                    </button>
                    <a href="{{ route('admin.pengumuman.index') }}"
                       class="rounded-xl border border-slate-300 px-4 py-3">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-5 py-4">Pengumuman</th>
                            <th class="px-5 py-4">Cakupan</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengumuman as $item)
                            <tr class="align-top hover:bg-slate-50">
                                <td class="max-w-md px-5 py-4">
                                    <p class="font-semibold text-slate-800">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="mt-1 text-slate-500">
                                        {{ \Illuminate\Support\Str::limit($item->isi, 100) }}
                                    </p>
                                    <p class="mt-2 text-xs text-slate-400">
                                        Pembuat: {{ $item->pembuat?->name ?? 'Pengguna tidak tersedia' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($item->cakupan === 'kelas')
                                        Kelas: {{ $item->kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}
                                    @else
                                        Seluruh sekolah
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    @if ($item->status === 'dipublikasikan')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Dipublikasikan
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Draf
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                                    {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                                           class="font-semibold text-blue-600 hover:underline">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="font-semibold text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                    Belum ada pengumuman. Klik tombol Buat Pengumuman untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 p-5">
                {{ $pengumuman->links() }}
            </div>
        </section>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm font-semibold text-blue-600 hover:underline">
                ← Kembali ke Dashboard Admin
            </a>
        </div>
    </main>
</body>
</html>

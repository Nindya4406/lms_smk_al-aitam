
@csrf

<div class="space-y-6">

    <div>
        <label for="kode_mapel"
               class="mb-2 block text-sm font-semibold text-slate-700">
            Kode Mata Pelajaran
        </label>

        <input
            type="text"
            id="kode_mapel"
            name="kode_mapel"
            value="{{ old('kode_mapel', $mataPelajaran?->kode_mapel) }}"
            maxlength="20"
            placeholder="Contoh: MTK"
            required
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm uppercase outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >

        @error('kode_mapel')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <p class="mt-2 text-xs text-slate-500">
            Contoh kode: MTK, BIND, BING, atau PJOK. Setiap kode harus unik.
        </p>
    </div>

    <div>
        <label for="nama_mapel"
               class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Mata Pelajaran
        </label>

        <input
            type="text"
            id="nama_mapel"
            name="nama_mapel"
            value="{{ old('nama_mapel', $mataPelajaran?->nama_mapel) }}"
            maxlength="255"
            placeholder="Contoh: Matematika"
            required
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >

        @error('nama_mapel')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a
        href="{{ route('admin.mata-pelajaran.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
    >
        {{ $tombolSimpan }}
    </button>
</div>

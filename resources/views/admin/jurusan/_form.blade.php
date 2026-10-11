
<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf

    @if ($httpMethod !== 'POST')
        @method($httpMethod)
    @endif

    {{-- Nama Jurusan --}}
    <div>
        <label
            for="nama_jurusan"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Nama Jurusan
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            id="nama_jurusan"
            name="nama_jurusan"
            value="{{ old('nama_jurusan', $jurusan?->nama_jurusan) }}"
            placeholder="Contoh: Desain Komunikasi Visual"
            maxlength="255"
            required
            autofocus
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 @error('nama_jurusan') border-red-400 focus:border-red-500 focus:ring-red-50 @enderror"
        >

        @error('nama_jurusan')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Kode Jurusan --}}
    <div>
        <label
            for="kode_jurusan"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Kode Jurusan
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            id="kode_jurusan"
            name="kode_jurusan"
            value="{{ old('kode_jurusan', $jurusan?->kode_jurusan) }}"
            placeholder="Contoh: DKV"
            maxlength="20"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 uppercase outline-none transition placeholder:normal-case placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 @error('kode_jurusan') border-red-400 focus:border-red-500 focus:ring-red-50 @enderror"
        >

        <p class="mt-2 text-xs leading-5 text-slate-500">
            Gunakan huruf, angka, tanda hubung, atau garis bawah.
            Contoh: DKV, TJKT, TKRO, dan MPLB.
        </p>

        @error('kode_jurusan')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Tombol aksi --}}
    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

        <a
            href="{{ route('admin.jurusan.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
        >
            Batal
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
        >
            {{ $buttonLabel }}
        </button>

    </div>
</form>

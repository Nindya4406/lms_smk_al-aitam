
<div class="space-y-6">
    <div>
        <label for="nama_kelas" class="mb-2 block text-sm font-semibold">
            Nama Kelas <span class="text-red-500">*</span>
        </label>

        <input
            id="nama_kelas"
            name="nama_kelas"
            type="text"
            value="{{ old('nama_kelas', $kelas?->nama_kelas) }}"
            placeholder="Contoh: X DKV 1"
            maxlength="255"
            required
            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
        >

        @error('nama_kelas')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="jurusan_id" class="mb-2 block text-sm font-semibold">
                Jurusan <span class="text-red-500">*</span>
            </label>

            <select id="jurusan_id" name="jurusan_id" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
                <option value="">Pilih jurusan</option>

                @foreach ($jurusan as $item)
                    <option value="{{ $item->id }}"
                        @selected((string) old('jurusan_id', $kelas?->jurusan_id) === (string) $item->id)>
                        {{ $item->nama_jurusan }}
                    </option>
                @endforeach
            </select>

            @error('jurusan_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($jurusan->isEmpty())
                <p class="mt-2 text-sm text-amber-600">
                    Tambahkan jurusan terlebih dahulu.
                </p>
            @endif
        </div>

        <div>
            <label for="tingkat" class="mb-2 block text-sm font-semibold">
                Tingkat <span class="text-red-500">*</span>
            </label>

            <select id="tingkat" name="tingkat" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
                <option value="">Pilih tingkat</option>

                @foreach (['X', 'XI', 'XII'] as $tingkat)
                    <option value="{{ $tingkat }}"
                        @selected(old('tingkat', $kelas?->tingkat) === $tingkat)>
                        {{ $tingkat }}
                    </option>
                @endforeach
            </select>

            @error('tingkat')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="tahun_ajaran" class="mb-2 block text-sm font-semibold">
            Tahun Ajaran <span class="text-red-500">*</span>
        </label>

        <input
            id="tahun_ajaran"
            name="tahun_ajaran"
            type="text"
            value="{{ old('tahun_ajaran', $kelas?->tahun_ajaran) }}"
            placeholder="2026/2027"
            maxlength="20"
            pattern="[0-9]{4}/[0-9]{4}"
            required
            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
        >

        @error('tahun_ajaran')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="wali_kelas_id" class="mb-2 block text-sm font-semibold">
            Wali Kelas
        </label>

        <select id="wali_kelas_id" name="wali_kelas_id"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
            <option value="">Belum ditentukan</option>

            @foreach ($guru as $item)
                <option value="{{ $item->id }}"
                    @selected((string) old('wali_kelas_id', $kelas?->wali_kelas_id) === (string) $item->id)>
                    {{ $item->name }} — {{ $item->email }}
                </option>
            @endforeach
        </select>

        @error('wali_kelas_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <p class="mt-2 text-xs text-slate-500">
            Hanya guru aktif yang belum menjadi wali kelas lain yang dapat dipilih.
        </p>
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
    <a href="{{ route('admin.kelas.index') }}"
       class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold hover:bg-slate-50">
        Batal
    </a>

    <button type="submit"
            class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
        {{ $buttonLabel }}
    </button>
</div>

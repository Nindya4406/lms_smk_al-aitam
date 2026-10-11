
@csrf

<div class="space-y-5">
    <div>
        <label for="guru_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Guru
        </label>

        <select
            id="guru_id"
            name="guru_id"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"
        >
            <option value="">Pilih Guru</option>

            @foreach ($guruList as $guru)
                <option
                    value="{{ $guru->id }}"
                    @selected((string) old('guru_id', $penugasanGuru?->guru_id) === (string) $guru->id)
                >
                    {{ $guru->name }} — {{ $guru->email }}
                </option>
            @endforeach
        </select>

        @error('guru_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="kelas_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Kelas
        </label>

        <select
            id="kelas_id"
            name="kelas_id"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"
        >
            <option value="">Pilih Kelas</option>

            @foreach ($kelasList as $kelas)
                <option
                    value="{{ $kelas->id }}"
                    @selected((string) old('kelas_id', $penugasanGuru?->kelas_id) === (string) $kelas->id)
                >
                    {{ $kelas->nama_kelas }}
                    — {{ $kelas->jurusan?->nama_jurusan ?? 'Tanpa jurusan' }}
                    — Tingkat {{ $kelas->tingkat }}
                    — {{ $kelas->tahun_ajaran }}
                </option>
            @endforeach
        </select>

        @error('kelas_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="mata_pelajaran_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Mata Pelajaran
        </label>

        <select
            id="mata_pelajaran_id"
            name="mata_pelajaran_id"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none"
        >
            <option value="">Pilih Mata Pelajaran</option>

            @foreach ($mataPelajaranList as $mapel)
                <option
                    value="{{ $mapel->id }}"
                    @selected((string) old('mata_pelajaran_id', $penugasanGuru?->mata_pelajaran_id) === (string) $mapel->id)
                >
                    {{ $mapel->kode_mapel }} — {{ $mapel->nama_mapel }}
                </option>
            @endforeach
        </select>

        @error('mata_pelajaran_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a
        href="{{ route('admin.penugasan-guru.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700"
    >
        {{ $tombolSimpan }}
    </button>
</div>

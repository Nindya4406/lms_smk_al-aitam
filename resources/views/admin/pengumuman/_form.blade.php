@php
    $dataPengumuman = $pengumuman ?? null;
@endphp

<div class="space-y-6">
    <div>
        <label for="judul" class="mb-2 block font-semibold">Judul Pengumuman</label>
        <input type="text" id="judul" name="judul"
               value="{{ old('judul', $dataPengumuman?->judul) }}"
               maxlength="200" required
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none">
        @error('judul')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="isi" class="mb-2 block font-semibold">Isi Pengumuman</label>
        <textarea id="isi" name="isi" rows="7" required
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none"
                  placeholder="Tuliskan informasi pengumuman secara lengkap...">{{ old('isi', $dataPengumuman?->isi) }}</textarea>
        @error('isi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="cakupan" class="mb-2 block font-semibold">Cakupan Pengumuman</label>
        <select id="cakupan" name="cakupan" required
                class="w-full rounded-xl border border-slate-300 px-4 py-3">
            <option value="sekolah"
                @selected(old('cakupan', $dataPengumuman?->cakupan ?? 'sekolah') === 'sekolah')>
                Seluruh Sekolah
            </option>
            <option value="kelas"
                @selected(old('cakupan', $dataPengumuman?->cakupan) === 'kelas')>
                Kelas Tertentu
            </option>
        </select>
        @error('cakupan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div id="pilihan-kelas">
        <label for="kelas_id" class="mb-2 block font-semibold">Kelas Tujuan</label>
        <select id="kelas_id" name="kelas_id"
                class="w-full rounded-xl border border-slate-300 px-4 py-3">
            <option value="">-- Pilih Kelas --</option>
            @foreach ($kelasList as $kelas)
                <option value="{{ $kelas->id }}"
                    @selected((string) old('kelas_id', $dataPengumuman?->kelas_id) === (string) $kelas->id)>
                    {{ $kelas->nama_kelas }}
                    — {{ $kelas->jurusan?->nama_jurusan ?? 'Tanpa jurusan' }}
                    ({{ $kelas->tahun_ajaran }})
                </option>
            @endforeach
        </select>
        @error('kelas_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="mb-2 block font-semibold">Status</label>
        <select id="status" name="status" required
                class="w-full rounded-xl border border-slate-300 px-4 py-3">
            <option value="draft"
                @selected(old('status', $dataPengumuman?->status ?? 'draft') === 'draft')>
                Draf — Belum dipublikasikan
            </option>
            <option value="dipublikasikan"
                @selected(old('status', $dataPengumuman?->status ?? 'draft') === 'dipublikasikan')>
                Dipublikasikan
            </option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.pengumuman.index') }}"
           class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold">
            Batal
        </a>
        <button type="submit"
                class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">
            Simpan Pengumuman
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cakupan = document.getElementById('cakupan');
        const pilihanKelas = document.getElementById('pilihan-kelas');
        const kelasId = document.getElementById('kelas_id');

        function aturPilihanKelas() {
            const untukKelas = cakupan.value === 'kelas';

            pilihanKelas.hidden = !untukKelas;
            kelasId.required = untukKelas;

            if (!untukKelas) {
                kelasId.value = '';
            }
        }

        cakupan.addEventListener('change', aturPilihanKelas);
        aturPilihanKelas();
    });
</script>

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with(['pembuat', 'kelas'])
            ->latest();

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('isi', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengumuman = $query->paginate(10)->withQueryString();

        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        $kelasList = Kelas::with('jurusan')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.pengumuman.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'cakupan' => ['required', Rule::in(['sekolah', 'kelas'])],
            'kelas_id' => [
                Rule::requiredIf($request->cakupan === 'kelas'),
                'nullable',
                'integer',
                'exists:kelas,id',
            ],
            'status' => ['required', Rule::in(['draft', 'dipublikasikan'])],
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul maksimal 200 karakter.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'cakupan.required' => 'Cakupan pengumuman wajib dipilih.',
            'kelas_id.required' => 'Pilih kelas tujuan pengumuman.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'status.required' => 'Status pengumuman wajib dipilih.',
        ]);

        if ($validated['cakupan'] === 'sekolah') {
            $validated['kelas_id'] = null;
        }

        $validated['pembuat_id'] = Auth::id();
        $validated['tanggal_publikasi'] =
            $validated['status'] === 'dipublikasikan'
                ? now()
                : null;

        Pengumuman::create($validated);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $kelasList = Kelas::with('jurusan')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.pengumuman.edit', compact(
            'pengumuman',
            'kelasList'
        ));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'cakupan' => ['required', Rule::in(['sekolah', 'kelas'])],
            'kelas_id' => [
                Rule::requiredIf($request->cakupan === 'kelas'),
                'nullable',
                'integer',
                'exists:kelas,id',
            ],
            'status' => ['required', Rule::in(['draft', 'dipublikasikan'])],
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul maksimal 200 karakter.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'cakupan.required' => 'Cakupan pengumuman wajib dipilih.',
            'kelas_id.required' => 'Pilih kelas tujuan pengumuman.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'status.required' => 'Status pengumuman wajib dipilih.',
        ]);

        if ($validated['cakupan'] === 'sekolah') {
            $validated['kelas_id'] = null;
        }

        $validated['tanggal_publikasi'] =
            $validated['status'] === 'dipublikasikan'
                ? ($pengumuman->tanggal_publikasi ?? now())
                : null;

        $pengumuman->update($validated);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}

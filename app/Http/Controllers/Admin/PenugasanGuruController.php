<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PenugasanGuru;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenugasanGuruController extends Controller
{
    /**
     * Menampilkan penugasan mengajar dan pengaturan wali kelas.
     */
    public function index(): View
    {
        $penugasan = PenugasanGuru::with([
            'guru',
            'kelas.jurusan',
            'mataPelajaran',
        ])
            ->latest()
            ->paginate(10);

        $kelasList = Kelas::with([
            'jurusan',
            'waliKelas',
        ])
            ->orderBy('tahun_ajaran')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        $guruList = User::where('role', 'guru')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get();

        return view('admin.penugasan-guru.index', compact(
            'penugasan',
            'kelasList',
            'guruList'
        ));
    }

    /**
     * Menampilkan formulir penugasan baru.
     */
    public function create(): View
    {
        return view('admin.penugasan-guru.create', [
            'guruList' => $this->getGuruList(),
            'kelasList' => $this->getKelasList(),
            'mataPelajaranList' => $this->getMataPelajaranList(),
            'penugasanGuru' => null,
        ]);
    }

    /**
     * Menyimpan penugasan mengajar baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guru_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'guru')
                    ->where('status', 'aktif'),
            ],
            'kelas_id' => [
                'required',
                'integer',
                'exists:kelas,id',
            ],
            'mata_pelajaran_id' => [
                'required',
                'integer',
                Rule::exists('mata_pelajaran', 'id')
                    ->where('aktif', true),
            ],
        ], [
            'guru_id.required' => 'Guru wajib dipilih.',
            'guru_id.exists' => 'Guru tidak ditemukan atau akunnya tidak aktif.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists' => 'Mata pelajaran tidak ditemukan atau tidak aktif.',
        ]);

        $sudahDitugaskan = PenugasanGuru::where(
            'guru_id',
            $validated['guru_id']
        )
            ->where('kelas_id', $validated['kelas_id'])
            ->where(
                'mata_pelajaran_id',
                $validated['mata_pelajaran_id']
            )
            ->exists();

        if ($sudahDitugaskan) {
            return back()
                ->withErrors([
                    'guru_id' => 'Penugasan Guru untuk kelas dan mata pelajaran tersebut sudah ada.',
                ])
                ->withInput();
        }

        PenugasanGuru::create($validated);

        return redirect()
            ->route('admin.penugasan-guru.index')
            ->with('success', 'Penugasan Guru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit penugasan.
     */
    public function edit(
        PenugasanGuru $penugasanGuru
    ): View {
        return view('admin.penugasan-guru.edit', [
            'penugasanGuru' => $penugasanGuru,
            'guruList' => $this->getGuruList(),
            'kelasList' => $this->getKelasList(),
            'mataPelajaranList' => $this->getMataPelajaranList(),
        ]);
    }

    /**
     * Memperbarui penugasan Guru.
     */
    public function update(
        Request $request,
        PenugasanGuru $penugasanGuru
    ): RedirectResponse {
        $validated = $request->validate([
            'guru_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'guru')
                    ->where('status', 'aktif'),
            ],
            'kelas_id' => [
                'required',
                'integer',
                'exists:kelas,id',
            ],
            'mata_pelajaran_id' => [
                'required',
                'integer',
                Rule::exists('mata_pelajaran', 'id')
                    ->where('aktif', true),
            ],
        ], [
            'guru_id.required' => 'Guru wajib dipilih.',
            'guru_id.exists' => 'Guru tidak ditemukan atau akunnya tidak aktif.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists' => 'Mata pelajaran tidak ditemukan atau tidak aktif.',
        ]);

        $duplikat = PenugasanGuru::where(
            'guru_id',
            $validated['guru_id']
        )
            ->where('kelas_id', $validated['kelas_id'])
            ->where(
                'mata_pelajaran_id',
                $validated['mata_pelajaran_id']
            )
            ->where('id', '!=', $penugasanGuru->id)
            ->exists();

        if ($duplikat) {
            return back()
                ->withErrors([
                    'guru_id' => 'Penugasan Guru untuk kelas dan mata pelajaran tersebut sudah ada.',
                ])
                ->withInput();
        }

        $penugasanGuru->update($validated);

        return redirect()
            ->route('admin.penugasan-guru.index')
            ->with('success', 'Penugasan Guru berhasil diperbarui.');
    }

    /**
     * Menghapus satu penugasan mengajar.
     */
    public function destroy(
        PenugasanGuru $penugasanGuru
    ): RedirectResponse {
        $penugasanGuru->delete();

        return redirect()
            ->route('admin.penugasan-guru.index')
            ->with('success', 'Penugasan Guru berhasil dihapus.');
    }

    /**
     * Menetapkan atau mengganti wali kelas.
     */
    public function assignWaliKelas(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'kelas_id' => [
                'required',
                'integer',
                'exists:kelas,id',
            ],
            'guru_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'guru')
                    ->where('status', 'aktif'),
            ],
        ], [
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak ditemukan.',
            'guru_id.exists' => 'Wali kelas harus berupa akun Guru yang aktif.',
        ]);

        $kelas = Kelas::findOrFail($validated['kelas_id']);
        $guruId = $validated['guru_id'] ?? null;

        if ($guruId !== null) {
            $sudahMenjadiWali = Kelas::where(
                'wali_kelas_id',
                $guruId
            )
                ->where('id', '!=', $kelas->id)
                ->exists();

            if ($sudahMenjadiWali) {
                return back()
                    ->withErrors([
                        'guru_id' => 'Guru tersebut sudah menjadi wali kelas di kelas lain.',
                    ])
                    ->withInput();
            }
        }

        $kelas->wali_kelas_id = $guruId;
        $kelas->save();

        return redirect()
            ->route('admin.penugasan-guru.index')
            ->with(
                'success',
                $guruId
                    ? 'Wali kelas berhasil ditetapkan.'
                    : 'Wali kelas berhasil dikosongkan.'
            );
    }

    /**
     * Daftar Guru aktif untuk pilihan formulir.
     */
    private function getGuruList()
    {
        return User::where('role', 'guru')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get();
    }

    /**
     * Daftar kelas beserta jurusannya.
     */
    private function getKelasList()
    {
        return Kelas::with('jurusan')
            ->orderBy('tahun_ajaran')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();
    }

    /**
     * Daftar mata pelajaran aktif.
     */
    private function getMataPelajaranList()
    {
        return MataPelajaran::where('aktif', true)
            ->orderBy('nama_mapel')
            ->get();
    }
}

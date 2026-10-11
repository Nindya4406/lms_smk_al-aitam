<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('search', ''));

        $kelas = Kelas::with(['jurusan', 'waliKelas'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery
                        ->where('nama_kelas', 'like', "%{$keyword}%")
                        ->orWhere('tingkat', 'like', "%{$keyword}%")
                        ->orWhere('tahun_ajaran', 'like', "%{$keyword}%")
                        ->orWhereHas('jurusan', function ($jurusanQuery) use ($keyword) {
                            $jurusanQuery->where(
                                'nama_jurusan',
                                'like',
                                "%{$keyword}%"
                            );
                        })
                        ->orWhereHas('waliKelas', function ($guruQuery) use ($keyword) {
                            $guruQuery->where(
                                'name',
                                'like',
                                "%{$keyword}%"
                            );
                        });
                });
            })
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kelas.index', compact('kelas', 'keyword'));
    }

    public function create()
    {
        $kelas = null;
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        $guru = $this->getPilihanWaliKelas($kelas);

        return view('admin.kelas.create', compact('kelas', 'jurusan', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateKelas($request);

        Kelas::create($validated);

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        $guru = $this->getPilihanWaliKelas($kelas);

        return view('admin.kelas.edit', compact('kelas', 'jurusan', 'guru'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $this->validateKelas($request, $kelas);

        $kelas->update($validated);

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $idKelas = $kelas->id;

        try {
            $berhasilDihapus = $kelas->delete();

            // Pastikan penghapusan benar-benar terjadi.
            $masihAda = Kelas::whereKey($idKelas)->exists();

            if (!$berhasilDihapus || $masihAda) {
                return redirect()
                    ->route('admin.kelas.index')
                    ->with(
                        'error',
                        'Data kelas belum berhasil dihapus. Silakan periksa kembali.'
                    );
            }

            return redirect()
                ->route('admin.kelas.index')
                ->with('success', 'Data kelas berhasil dihapus.');
        } catch (QueryException $exception) {
            report($exception);

            return redirect()
                ->route('admin.kelas.index')
                ->with(
                    'error',
                    'Kelas tidak dapat dihapus karena masih digunakan oleh data lain.'
                );
        }
    }

    private function getPilihanWaliKelas(?Kelas $kelas)
    {
        $waliKelasTerpakai = Kelas::query()
            ->whereNotNull('wali_kelas_id')
            ->when(
                $kelas,
                fn ($query) => $query->where('id', '!=', $kelas->id)
            )
            ->pluck('wali_kelas_id');

        return User::query()
            ->where('role', 'guru')
            ->where('status', 'aktif')
            ->where(function ($query) use ($waliKelasTerpakai, $kelas) {
                $query->whereNotIn('id', $waliKelasTerpakai);

                if ($kelas && $kelas->wali_kelas_id) {
                    $query->orWhere('id', $kelas->wali_kelas_id);
                }
            })
            ->orderBy('name')
            ->get();
    }

    private function validateKelas(
        Request $request,
        ?Kelas $kelas = null
    ): array {
        $namaKelasRule = Rule::unique('kelas', 'nama_kelas')
            ->where(function ($query) use ($request) {
                $query
                    ->where('jurusan_id', $request->input('jurusan_id'))
                    ->where('tingkat', $request->input('tingkat'))
                    ->where('tahun_ajaran', $request->input('tahun_ajaran'));
            });

        if ($kelas) {
            $namaKelasRule->ignore($kelas->id);
        }

        return $request->validate([
            'jurusan_id' => [
                'required',
                'integer',
                'exists:jurusan,id',
            ],

            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                $namaKelasRule,
            ],

            'tingkat' => [
                'required',
                'integer',
                Rule::in([10, 11, 12]),
            ],

            'tahun_ajaran' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
            ],

            'wali_kelas_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where(fn ($query) => $query
                        ->where('role', 'guru')
                        ->where('status', 'aktif')),
                Rule::unique('kelas', 'wali_kelas_id')
                    ->ignore($kelas?->id),
            ],
        ], [
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak ditemukan.',

            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique' => 'Kombinasi nama kelas, jurusan, tingkat, dan tahun ajaran sudah digunakan.',

            'tingkat.required' => 'Tingkat kelas wajib dipilih.',
            'tingkat.integer' => 'Tingkat kelas tidak valid.',
            'tingkat.in' => 'Tingkat kelas harus X, XI, atau XII.',

            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tahun_ajaran.regex' => 'Format tahun ajaran harus seperti 2026/2027.',

            'wali_kelas_id.exists' => 'Wali kelas harus merupakan akun guru yang aktif.',
            'wali_kelas_id.unique' => 'Guru tersebut sudah menjadi wali kelas di kelas lain.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('search', ''));

        $mataPelajaran = MataPelajaran::query()
            ->withCount('penugasanGuru')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('nama_mapel', 'like', "%{$keyword}%")
                        ->orWhere('kode_mapel', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('nama_mapel')
            ->paginate(10)
            ->withQueryString();

        $totalMataPelajaran = MataPelajaran::count();

        return view('admin.mata-pelajaran.index', compact(
            'mataPelajaran',
            'keyword',
            'totalMataPelajaran'
        ));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mapel' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                Rule::unique('mata_pelajaran', 'kode_mapel'),
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.alpha_dash' => 'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'kode_mapel.unique' => 'Kode mata pelajaran sudah digunakan.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
        ]);

        $validated['kode_mapel'] = strtoupper($validated['kode_mapel']);

        MataPelajaran::create($validated);

        return redirect()
            ->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(
        Request $request,
        MataPelajaran $mataPelajaran
    ) {
        $validated = $request->validate([
            'kode_mapel' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                Rule::unique('mata_pelajaran', 'kode_mapel')
                    ->ignore($mataPelajaran->id),
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.alpha_dash' => 'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'kode_mapel.unique' => 'Kode mata pelajaran sudah digunakan.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
        ]);

        $validated['kode_mapel'] = strtoupper($validated['kode_mapel']);

        $mataPelajaran->update($validated);

        return redirect()
            ->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        try {
            if ($mataPelajaran->penugasanGuru()->exists()) {
                return redirect()
                    ->route('admin.mata-pelajaran.index')
                    ->with(
                        'error',
                        'Mata pelajaran tidak dapat dihapus karena sudah digunakan dalam penugasan guru.'
                    );
            }

            $id = $mataPelajaran->id;
            $berhasil = $mataPelajaran->delete();
            $masihAda = MataPelajaran::whereKey($id)->exists();

            if (! $berhasil || $masihAda) {
                return redirect()
                    ->route('admin.mata-pelajaran.index')
                    ->with('error', 'Mata pelajaran belum berhasil dihapus.');
            }

            return redirect()
                ->route('admin.mata-pelajaran.index')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (QueryException $exception) {
            report($exception);

            return redirect()
                ->route('admin.mata-pelajaran.index')
                ->with(
                    'error',
                    'Mata pelajaran tidak dapat dihapus karena masih digunakan oleh data lain.'
                );
        }
    }
}

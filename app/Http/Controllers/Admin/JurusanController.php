<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JurusanController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->query('search');

        $jurusan = Jurusan::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery
                        ->where('nama_jurusan', 'like', "%{$keyword}%")
                        ->orWhere('kode_jurusan', 'like', "%{$keyword}%");
                });
            })
            ->withCount('kelas')
            ->orderBy('nama_jurusan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.jurusan.index', compact(
            'jurusan',
            'keyword'
        ));
    }

    public function create(): View
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jurusan' => [
                'required',
                'string',
                'max:255',
            ],
            'kode_jurusan' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                'unique:jurusan,kode_jurusan',
            ],
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'kode_jurusan.required' => 'Kode jurusan wajib diisi.',
            'kode_jurusan.alpha_dash' =>
                'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'kode_jurusan.unique' => 'Kode jurusan sudah digunakan.',
        ]);

        Jurusan::create($validated);

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan): View
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(
        Request $request,
        Jurusan $jurusan
    ): RedirectResponse {
        $validated = $request->validate([
            'nama_jurusan' => [
                'required',
                'string',
                'max:255',
            ],
            'kode_jurusan' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                Rule::unique('jurusan', 'kode_jurusan')
                    ->ignore($jurusan->id),
            ],
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'kode_jurusan.required' => 'Kode jurusan wajib diisi.',
            'kode_jurusan.alpha_dash' =>
                'Kode hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'kode_jurusan.unique' => 'Kode jurusan sudah digunakan.',
        ]);

        $jurusan->update($validated);

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        if ($jurusan->kelas()->exists()) {
            return redirect()
                ->route('admin.jurusan.index')
                ->with(
                    'error',
                    'Jurusan tidak bisa dihapus karena masih memiliki kelas.'
                );
        }

        $jurusan->delete();

        return redirect()
            ->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}

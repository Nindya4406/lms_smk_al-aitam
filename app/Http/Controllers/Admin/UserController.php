<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('search', ''));

        $users = User::query()
            ->whereIn('role', ['guru', 'siswa'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('role', 'like', "%{$keyword}%");
                });
            })
            ->when(
                in_array($request->input('role'), ['guru', 'siswa'], true),
                fn ($query) => $query->where('role', $request->input('role'))
            )
            ->when(
                in_array($request->input('status'), ['aktif', 'nonaktif'], true),
                fn ($query) => $query->where('status', $request->input('status'))
            )
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'keyword' => $keyword,
            'roleFilter' => $request->input('role', ''),
            'statusFilter' => $request->input('status', ''),
            'totalGuru' => User::where('role', 'guru')->count(),
            'totalSiswa' => User::where('role', 'siswa')->count(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'role' => ['required', Rule::in(['guru', 'siswa'])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role hanya boleh Guru atau Siswa.',
            'status.required' => 'Status akun wajib dipilih.',
            'status.in' => 'Status akun tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        abort_unless(in_array($user->role, ['guru', 'siswa'], true), 404);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(in_array($user->role, ['guru', 'siswa'], true), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['guru', 'siswa'])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.in' => 'Role hanya boleh Guru atau Siswa.',
            'status.in' => 'Status akun tidak valid.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (! in_array($user->role, ['guru', 'siswa'], true)) {
            abort(404);
        }

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Kamu tidak dapat menghapus akun yang sedang digunakan.');
        }

        try {
            $user->delete();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Akun berhasil dihapus.');
        } catch (QueryException $exception) {
            report($exception);

            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Akun tidak dapat dihapus karena masih terhubung dengan data sekolah. Nonaktifkan akun jika pengguna sudah tidak aktif.'
                );
        }
    }
}

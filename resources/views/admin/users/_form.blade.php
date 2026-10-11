
@csrf

<div class="space-y-5">

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Lengkap
        </label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $user?->name) }}"
            required
            maxlength="255"
            autocomplete="name"
            placeholder="Masukkan nama lengkap"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
            Email
        </label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $user?->email) }}"
            required
            maxlength="255"
            autocomplete="email"
            placeholder="nama@contoh.com"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">
            Role Pengguna
        </label>
        <select
            id="role"
            name="role"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >
            <option value="">Pilih role</option>
            <option value="guru" @selected(old('role', $user?->role) === 'guru')>
                Guru
            </option>
            <option value="siswa" @selected(old('role', $user?->role) === 'siswa')>
                Siswa
            </option>
        </select>
        @error('role')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-xs text-slate-500">
            Akun Admin tidak dibuat melalui formulir ini.
        </p>
    </div>

    <div>
        <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
            Status Akun
        </label>
        <select
            id="status"
            name="status"
            required
            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
        >
            <option value="aktif" @selected(old('status', $user?->status ?? 'aktif') === 'aktif')>
                Aktif
            </option>
            <option value="nonaktif" @selected(old('status', $user?->status) === 'nonaktif')>
                Nonaktif
            </option>
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
        <h3 class="text-sm font-semibold text-slate-800">
            {{ $user ? 'Ubah Password (Opsional)' : 'Password Awal' }}
        </h3>
        <p class="mt-1 text-xs leading-5 text-slate-600">
            {{ $user ? 'Kosongkan jika password tidak ingin diubah.' : 'Buat password minimal 8 karakter dan sampaikan dengan aman kepada pengguna.' }}
        </p>

        <div class="mt-4 space-y-4">
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    {{ $user ? '' : 'required' }}
                    minlength="8"
                    autocomplete="{{ $user ? 'new-password' : 'new-password' }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">
                    Konfirmasi Password
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    {{ $user ? '' : 'required' }}
                    minlength="8"
                    autocomplete="new-password"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                >
            </div>
        </div>
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a
        href="{{ route('admin.users.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50"
    >
        Batal
    </a>
    <button
        type="submit"
        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
    >
        {{ $tombolSimpan }}
    </button>
</div>

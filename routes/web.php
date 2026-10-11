
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PenugasanGuruController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Login dan Registrasi
|--------------------------------------------------------------------------
| Middleware guest sementara tidak digunakan untuk menghindari
| redirect loop ketika membuka halaman login.
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Profil Pengguna
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| Dashboard dan Manajemen Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('jurusan', JurusanController::class)
            ->except(['show']);

        Route::resource('kelas', KelasController::class)
            ->except(['show']);

        Route::resource('mata-pelajaran', MataPelajaranController::class)
            ->parameters([
                'mata-pelajaran' => 'mataPelajaran',
            ])
            ->except(['show']);

        Route::resource('pengumuman', PengumumanController::class)
            ->except(['show']);

        Route::post(
            '/penugasan-guru/wali-kelas',
            [PenugasanGuruController::class, 'assignWaliKelas']
        )->name('penugasan-guru.wali-kelas');

        Route::resource('penugasan-guru', PenugasanGuruController::class)
            ->parameters([
                'penugasan-guru' => 'penugasanGuru',
            ])
            ->except(['show']);

        Route::resource('users', UserController::class)
            ->except(['show']);
    });

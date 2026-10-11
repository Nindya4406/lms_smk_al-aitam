<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'jumlahSiswa' => User::where('role', 'siswa')->count(),
            'jumlahGuru' => User::where('role', 'guru')->count(),
            'jumlahJurusan' => Jurusan::count(),
            'jumlahKelas' => Kelas::count(),
            'jumlahMataPelajaran' => MataPelajaran::count(),
        ]);
    }
}

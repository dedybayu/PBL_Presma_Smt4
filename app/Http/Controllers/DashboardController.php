<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('loginError', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $levelKode = $user->level->level_kode ?? null;

        switch ($levelKode) {
            case 'MHS':
                return view('mahasiswa.dashboard');
            case 'DOS':
                return view('dosen.dashboard');
            case 'ADM':
                $data = $this->getDashboardData();
                return view('admin.dashboard', $data);
            default:
                return redirect('/login')->with('loginError', 'Level tidak dikenali. Silakan login kembali.');
        }
    }

    public function getDashboardData()
    {
        // Statistik Lomba
        $totalLomba = LombaModel::count();
        $lombaVerifikasi = LombaModel::where('status_verifikasi', 1)->count(); // Terverifikasi
        $lombaPending = LombaModel::where('status_verifikasi', 2)->count();    // Pending (Menunggu)
        $lombaDitolak = LombaModel::where('status_verifikasi', 0)->count();    // Ditolak

        // Statistik Prestasi
        $totalPrestasi = PrestasiModel::count();
        $prestasiVerifikasi = PrestasiModel::where('status_verifikasi', 1)->count(); // Terverifikasi
        $prestasiPending = PrestasiModel::where('status_verifikasi', null)->count(); // Menunggu
        $prestasiDitolak = PrestasiModel::where('status_verifikasi', 0)->count();    // Ditolak

        return [
            'totalLomba' => $totalLomba,
            'lombaVerifikasi' => $lombaVerifikasi,
            'lombaPending' => $lombaPending,
            'lombaDitolak' => $lombaDitolak,
            'totalPrestasi' => $totalPrestasi,
            'prestasiVerifikasi' => $prestasiVerifikasi,
            'prestasiPending' => $prestasiPending,
            'prestasiDitolak' => $prestasiDitolak,
        ];
    }
}
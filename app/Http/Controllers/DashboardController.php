<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Support\Facades\DB;
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

        $prestasiPerTingkat = DB::table('m_tingkat_lomba as tingkat')
            ->leftJoin('m_lomba as lomba', 'tingkat.tingkat_lomba_id', '=', 'lomba.tingkat_lomba_id')
            ->leftJoin('t_prestasi as prestasi', 'lomba.lomba_id', '=', 'prestasi.lomba_id')
            ->select('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama', DB::raw('COUNT(prestasi.prestasi_id) as total_prestasi'))
            ->groupBy('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama')
            ->get();

        return [
            'prestasiPerTingkat' => $prestasiPerTingkat,
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
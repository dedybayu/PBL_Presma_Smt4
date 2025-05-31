<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $lombaPerTingkat = DB::table('m_tingkat_lomba as tingkat')
            ->leftJoin('m_lomba as lomba', 'tingkat.tingkat_lomba_id', '=', 'lomba.tingkat_lomba_id')
            ->select('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama', DB::raw('COUNT(lomba.lomba_id) as total_lomba'))
            ->groupBy('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama')
            ->get();

        $jadwalLombaPerBulan = DB::table('m_lomba')
            ->selectRaw("DATE_FORMAT(tanggal_mulai, '%Y-%m') as bulan, COUNT(*) as total")
            ->groupByRaw("DATE_FORMAT(tanggal_mulai, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(tanggal_mulai, '%Y-%m')")
            ->limit(10)
            ->get();

            // Format agar bulannya lebih user-friendly, contoh: "Mei 2025"
        $jadwalLombaPerBulanFormatted = $jadwalLombaPerBulan->map(function ($item) {
            $item->bulan_format = Carbon::createFromFormat('Y-m', $item->bulan)->translatedFormat('F Y');
            return $item;
        });

        $topMahasiswaPrestasi = DB::table('t_prestasi')
            ->join('m_mahasiswa as mahasiswa', 't_prestasi.mahasiswa_id', '=', 'mahasiswa.mahasiswa_id')
            ->select('mahasiswa.nama', DB::raw('COUNT(t_prestasi.prestasi_id) as total_prestasi'))
            ->groupBy('mahasiswa.mahasiswa_id', 'mahasiswa.nama')
            ->orderByDesc('total_prestasi')
            ->limit(8)
            ->get();

        return [
            'topMahasiswaPrestasi' => $topMahasiswaPrestasi,
            'jadwalLombaPerBulan' => $jadwalLombaPerBulanFormatted,
            'prestasiPerTingkat' => $prestasiPerTingkat,
            'lombaPerTingkat' => $lombaPerTingkat,
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
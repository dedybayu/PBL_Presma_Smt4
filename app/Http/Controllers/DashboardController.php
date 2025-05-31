<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
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
        // Set lokal bahasa Indonesia
        Carbon::setLocale('id');
        App::setLocale('id');

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

        // Prestasi per tingkat lomba
        $prestasiPerTingkat = DB::table('m_tingkat_lomba as tingkat')
            ->leftJoin('m_lomba as lomba', 'tingkat.tingkat_lomba_id', '=', 'lomba.tingkat_lomba_id')
            ->leftJoin('t_prestasi as prestasi', 'lomba.lomba_id', '=', 'prestasi.lomba_id')
            ->select('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama', DB::raw('COUNT(prestasi.prestasi_id) as total_prestasi'))
            ->groupBy('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama')
            ->get();

        // Lomba per tingkat
        $lombaPerTingkat = DB::table('m_tingkat_lomba as tingkat')
            ->leftJoin('m_lomba as lomba', 'tingkat.tingkat_lomba_id', '=', 'lomba.tingkat_lomba_id')
            ->select('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama', DB::raw('COUNT(lomba.lomba_id) as total_lomba'))
            ->groupBy('tingkat.tingkat_lomba_id', 'tingkat.tingkat_lomba_nama')
            ->get();

        // Jumlah lomba per bulan
        $jadwalLombaPerBulan = DB::table('m_lomba')
            ->selectRaw("YEAR(tanggal_mulai) as tahun, MONTH(tanggal_mulai) as bulan_angka, COUNT(*) as total")
            ->whereNotNull('tanggal_mulai')
            ->groupBy('tahun', 'bulan_angka')
            ->orderBy('tahun')
            ->orderBy('bulan_angka')
            ->limit(12)
            ->get()
            ->map(function ($item) {
                $bulanFormat = Carbon::createFromDate($item->tahun, $item->bulan_angka, 1)->translatedFormat('F Y');
                return (object)[
                    'bulan_format' => $bulanFormat,
                    'total' => $item->total,
                ];
            });

        // Top mahasiswa dengan prestasi terbanyak
        $topMahasiswaPrestasi = DB::table('t_prestasi')
            ->join('m_mahasiswa as mahasiswa', 't_prestasi.mahasiswa_id', '=', 'mahasiswa.mahasiswa_id')
            ->select('mahasiswa.nama', DB::raw('COUNT(t_prestasi.prestasi_id) as total_prestasi'))
            ->groupBy('mahasiswa.mahasiswa_id', 'mahasiswa.nama')
            ->orderByDesc('total_prestasi')
            ->limit(8)
            ->get();

        return [
            'topMahasiswaPrestasi' => $topMahasiswaPrestasi,
            'jadwalLombaPerBulan' => $jadwalLombaPerBulan,
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
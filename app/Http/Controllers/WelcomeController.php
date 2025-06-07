<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $topMahasiswaPrestasi = DB::table('t_prestasi')
            ->join('m_mahasiswa as mahasiswa', 't_prestasi.mahasiswa_id', '=', 'mahasiswa.mahasiswa_id')
            ->where('t_prestasi.status_verifikasi', 1) // Hanya ambil prestasi terverifikasi
            ->select('mahasiswa.nama', DB::raw('COUNT(t_prestasi.prestasi_id) as total_prestasi'))
            ->groupBy('mahasiswa.mahasiswa_id', 'mahasiswa.nama')
            ->orderByDesc('total_prestasi')
            ->limit(8)
            ->get();

        $daftarLomba = LombaModel::where('status_verifikasi', 1)
            ->orderBy('created_at', 'desc') // berdasarkan waktu pendaftaran terbaru
            ->limit(3)
            ->get(['lomba_id', 'lomba_nama', 'tanggal_mulai', 'foto_pamflet']);


        return view('welcome', compact('topMahasiswaPrestasi', 'daftarLomba'));
    }
}

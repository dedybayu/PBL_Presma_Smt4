<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
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
                return view('admin.dashboard');
            default:
                return redirect('/login')->with('loginError', 'Level tidak dikenali. Silakan login kembali.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        } elseif (Auth::guard('dosen')->check()) {
            return view('dosen.dashboard');
        } elseif (Auth::guard('mahasiswa')->check()) {
            return view('mahasiswa.dashboard');
        }
        // return view('welcome');
        return redirect('/login')->with('loginError', 'Silakan login terlebih dahulu.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class DaftarMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = MahasiswaModel::all();
        return view('admin.daftar_mahasiswa', compact('mahasiswa'));
    }
}

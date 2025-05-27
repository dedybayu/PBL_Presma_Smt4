<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Illuminate\Http\Request;

class MahasiswaPrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahhasiswaId = auth()->user()->mahasiswa->mahasiswa_id;
        // dd($mahhasiswaId);
        $prestasi = PrestasiModel::where('mahasiswa_id', $mahhasiswaId)->get();
        return view('mahasiswa.prestasi.daftar_prestasi')->with([
            'prestasi' => $prestasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiModel $prestasi)
    {
        if ($prestasi->mahasiswa->user_id !== auth()->user()->user_id) {
            abort(403, 'Anda tidak diizinkan mengakses prestasi ini.');
        }

        return view('mahasiswa.prestasi.show_prestasi', compact('prestasi'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiModel $prestasi)
    {
        if ($prestasi->mahasiswa->user_id !== auth()->user()->user_id) {
            abort(403, 'Anda tidak diizinkan mengakses prestasi ini.');
        }
        $lomba = LombaModel::all();
        $dosen = DosenModel::all();
        return view('mahasiswa.prestasi.edit_prestasiku')->with([
            'prestasi' => $prestasi,
            'lomba' => $lomba,
            'dosen' => $dosen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiModel $prestasi)
    {
        return response()->json([
            'status' => false,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrestasiModel $prestasiModel)
    {
        //
    }
}

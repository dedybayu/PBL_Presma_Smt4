<?php

namespace App\Http\Controllers;

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
    public function show(PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrestasiModel $prestasiModel)
    {
        //
    }
}

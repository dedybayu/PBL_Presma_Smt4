<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\TingkatLombaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDosenLombaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        $dosenId = optional($user->dosen)->dosen_id;

        $search = $request->search;
        $tingkatLombaId = $request->tingkat_lomba_id;
        $statusVerifikasi = $request->status_verifikasi;

        $query = LombaModel::with(['penyelenggara', 'tingkat', 'bidang']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('lomba_nama', 'like', "%{$search}%")
                ->orWhereHas('penyelenggara', function ($q2) use ($search) {
                    $q2->where('penyelenggara_nama', 'like', "%{$search}%");
                });
            });
        }

        if ($tingkatLombaId) {
            $query->where('tingkat_lomba_id', $tingkatLombaId);
        }

        if ($statusVerifikasi !== null && $statusVerifikasi !== '') {
            $query->where('status_verifikasi', $statusVerifikasi);
        }

        $lomba = $query->orderBy('tanggal_selesai', 'desc')->paginate(10);
        $tingkat_lomba = TingkatLombaModel::all();

        return view('daftar_lomba.daftar_lomba', compact('lomba', 'tingkat_lomba'));
    }


    public function show($id)
    {
        $lomba = LombaModel::with(['penyelenggara', 'tingkat', 'bidang'])->findOrFail($id);
        return view('daftar_lomba.show_lomba', compact('lomba'));
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
     * Show the form for editing the specified resource.
     */
    public function edit(LombaModel $lombaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LombaModel $lombaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LombaModel $lombaModel)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\TingkatLombaModel;
use App\Models\PenyelenggaraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MahasiswaDosenLombaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        $dosenId = optional($user->dosen)->dosen_id;

        $search = $request->search;
        $tingkatLombaId = $request->tingkat_lomba_id;
        $bidangKeahlianId = $request->bidang_keahlian_id;
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

        if ($bidangKeahlianId) {
            $query->whereHas('bidang', function ($q) use ($bidangKeahlianId) {
                $q->where('bidang_keahlian_id', $bidangKeahlianId);
            });
        }

        $lomba = $query->orderBy('tanggal_selesai', 'desc')->paginate(10);
        $tingkat_lomba = TingkatLombaModel::all();
        $bidang_keahlian = BidangKeahlianModel::all();

        return view('daftar_lomba.daftar_lomba', compact('lomba', 'tingkat_lomba', 'bidang_keahlian'));
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
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('daftar_lomba.create_lomba')->with(['tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function store(Request $request)
    {
        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'lomba_deskripsi' => 'required|string|max:255',
            'link_website' => 'required|string|max:255',
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'foto_pamflet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $imagePath = null;
        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');
    
            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }
    
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/lomba/foto-pamflet');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
    
            $file->move($destinationPath, $filename);
            $imagePath = "lomba/foto-pamflet/$filename"; // Simpan path gambar
        }

        try {
            $lomba = LombaModel::create([
                'lomba_kode' => $request->lomba_kode,
                'lomba_nama' => $request->lomba_nama,
                'lomba_deskripsi' => $request->lomba_deskripsi,
                'link_website' => $request->link_website,
                'tingkat_lomba_id' => $request->tingkat_lomba_id,
                'bidang_keahlian_id' => $request->bidang_keahlian_id,
                'penyelenggara_id' => $request->penyelenggara_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'foto_pamflet' => $imagePath,
                'user_id' => auth()->user()->user_id,
                'status_verifikasi' => 2
            ]);
        } catch (\Throwable $e) {
            if (isset($lomba)) {
                $lomba->delete();
            }
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan data baru: ' . $e->getMessage()], 500);
        }
       

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
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

    public function confirm(LombaModel $lomba)
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('daftar_lombaconfirm_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LombaModel $lombaModel)
    {
        //
    }
}

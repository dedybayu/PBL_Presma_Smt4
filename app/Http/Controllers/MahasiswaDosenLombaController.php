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

        // $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        // $dosenId = optional($user->dosen)->dosen_id;

        $search = $request->search;
        $tingkatLombaId = $request->tingkat_lomba_id;
        $bidangKeahlianId = $request->bidang_keahlian_id;
        $statusVerifikasi = $request->status_verifikasi;

        $user = auth()->user();

        $query = LombaModel::with(['penyelenggara', 'tingkat', 'bidang'])
            ->where(function ($q) use ($user) {
                $q->where('status_verifikasi', 1)
                    ->orWhere('user_id', $user->user_id);
            });



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
    public function edit($id)
    {
        $user = auth()->user();
        $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        $dosenId = optional($user->dosen)->dosen_id;

        $lomba = LombaModel::findOrFail($id);

        if ($lomba->user_id !== $user->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data ini.');
        }

        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();

        return view('daftar_lomba.edit_lomba', compact('lomba', 'tingkat', 'bidang', 'penyelenggara'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        $dosenId = optional($user->dosen)->dosen_id;

        $lomba = LombaModel::findOrFail($id);

        if ($lomba->user_id !== $user->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki izin untuk memperbarui data ini.'
            ], 403);
        }

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

        $imagePath = $lomba->foto_pamflet;
        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = storage_path('app/public/lomba/foto-pamflet');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
                $file->move($destinationPath, $filename);
                $imagePath = "lomba/foto-pamflet/$filename";
            }
        }

        $lomba->update([
            'lomba_kode' => $request->lomba_kode,
            'lomba_nama' => $request->lomba_nama,
            'lomba_deskripsi' => $request->lomba_deskripsi,
            'link_website' => $request->link_website,
            'tingkat_lomba_id' => $request->tingkat_lomba_id,
            'bidang_keahlian_id' => $request->bidang_keahlian_id,
            'penyelenggara_id' => $request->penyelenggara_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto_pamflet' => $imagePath
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }


    public function confirm(LombaModel $lomba)
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('daftar_lomba.confirm_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $mahasiswaId = optional($user->mahasiswa)->mahasiswa_id;
        $dosenId = optional($user->dosen)->dosen_id;

        $lomba = LombaModel::findOrFail($id);

        if ($lomba->user_id !== $user->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus data ini.'
            ], 403);
        }

        try {
            if ($lomba->foto_pamflet && file_exists(storage_path("app/public/{$lomba->foto_pamflet}"))) {
                unlink(storage_path("app/public/{$lomba->foto_pamflet}"));
            }

            $lomba->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}

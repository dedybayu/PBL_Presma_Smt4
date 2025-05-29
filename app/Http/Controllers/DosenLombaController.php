<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Validator;

class DosenLombaController extends Controller
{
    public function index()
    {
        // Ambil data dengan pagination
        $lomba = LombaModel::with(['tingkatLomba.nama', 'bidangKeahlian.nama', 'penyelenggara.nama']) // jika relasi ini digunakan di Blade
            ->orderByDesc('created_at')
            ->paginate(8); // batasi 8 per halaman

        return view('dosen.lomba.daftar_lomba', [
            'lomba' => $lomba
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(LombaModel $prestasi)
    {
        return view('dosen.lomba.show_lomba', compact('lomba'));
    }

    public function edit(LombaModel $lomba)
    {
        $tingkatLomba = TingkatLombaModel::all();
        $bidangKeahlian = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('dosen.lomba.edit_lomba')->with([
            'lomba' => $lomba,
            'tingkatLomba' => $tingkatLomba,
            'bidangKeahlian' => $bidangKeahlian,
            'penyelenggara' => $penyelenggara
        ]);
    }

    public function update(Request $request, LombaModel $lomba)
    {
        // dd($request);

        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'lomba_deskripsi' => 'required|string|max:255',
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
        
        $prestasi->juara = $request->juara;
        $prestasi->dosen_id = $mhs->dosen_id;
        $prestasi->dosen_id = $request->dosen_id;
        $prestasi->lomba_id = $request->lomba_id;
        $prestasi->prestasi_nama = $request->prestasi_nama;
        $prestasi->tanggal_perolehan = $request->tanggal_perolehan;


        $nim_dosen = $mhs->nim;

        if ($request->hasFile('file_sertifikat')) {
            self::deleteFile($prestasi->file_sertifikat);
            $prestasi->file_sertifikat = self::saveFile($request, 'sertifikat', $nim_dosen, 'file_sertifikat');
        }

        if ($request->hasFile('file_bukti_foto')) {
            self::deleteFile($prestasi->file_bukti_foto);
            $prestasi->file_bukti_foto = self::saveFile($request, 'bukti_foto', $nim_dosen, 'file_bukti_foto');
        }

        if ($request->hasFile('file_surat_tugas')) {
            self::deleteFile($prestasi->file_surat_tugas);
            $prestasi->file_surat_tugas = self::saveFile($request, 'surat_tugas', $nim_dosen, 'file_surat_tugas');
        }

        if ($request->hasFile('file_surat_undangan')) {
            self::deleteFile($prestasi->file_surat_undangan);
            $prestasi->file_surat_undangan = self::saveFile($request, 'surat_undangan', $nim_dosen, 'file_surat_undangan');
        }

        if ($request->hasFile('file_proposal')) {
            self::deleteFile($prestasi->file_proposal);
            $prestasi->file_proposal = self::saveFile($request, 'proposal', $nim_dosen, 'file_proposal');
        }

        $prestasi->status_verifikasi = null;
        $prestasi->updated_at = Carbon::now();
        $prestasi->save();

        $prestasi->poin = self::hitungPoin($prestasi);

        $prestasi->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function confirm(LombaModel $prestasi)
    {
        return view('dosen.prestasi.confirm_delete_prestasi', compact('prestasi'));
    }
    public function destroy(LombaModel $prestasi)
    {
        try {
            self::deleteFile($prestasi->file_sertifikat);
            self::deleteFile($prestasi->file_bukti_foto);
            self::deleteFile($prestasi->file_surat_tugas);
            self::deleteFile($prestasi->file_surat_undangan);
            self::deleteFile($prestasi->file_proposal);

            $prestasi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
            ]);
        }
    }


    //STATIC METHOD

    private static function saveFile($requestFile, string $jenis, string $nim_dosen, string $nama_variabel)
    {
        if ($requestFile->hasFile($nama_variabel)) {
            // return response()->json(['error' => 'No file uploaded'], 400);
            $file = $requestFile->file($nama_variabel);

            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }

            // Nama file unik
            $filename = time() . '_' . $file->getClientOriginalName();

            // Pastikan folder penyimpanan ada
            $destinationPath = storage_path('app/public/dosen/' . $nim_dosen . '/prestasi/' . $jenis . '/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            // Pindahkan file
            $file->move($destinationPath, $filename);

            $imagePath = "dosen/$nim_dosen/prestasi/$jenis/$filename"; // Simpan path gambar
        } else {
            $imagePath = null;
        }
        return $imagePath;
    }

    private static function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private static function hitungPoin(LombaModel $prestasi)
    {
        $poin = 5;

        return $poin;
    }
}

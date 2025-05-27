<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\LombaModel;
use App\Models\PrestasiModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Validator;

class MahasiswaPrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswaId = auth()->user()->mahasiswa->mahasiswa_id;

        // Ambil data dengan pagination
        $prestasi = PrestasiModel::where('mahasiswa_id', $mahasiswaId)
            ->with(['lomba.tingkat', 'lomba.penyelenggara']) // jika relasi ini digunakan di Blade
            ->orderByDesc('created_at')
            ->paginate(6); // batasi 8 per halaman

        return view('mahasiswa.prestasi.daftar_prestasi', [
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
        // dd($request);

        $rules = [
            // 'mahasiswa_id' => 'required',
            'dosen_id' => 'required',
            'lomba_id' => 'required',
            'prestasi_nama' => 'required',
            'juara' => 'required',
            'nama_juara' => 'nullable',
            'tanggal_perolehan' => 'required|date',
            'file_sertifikat' => 'nullable|mimes:jpg,jpeg,png',
            'file_bukti_foto' => 'nullable|mimes:jpg,jpeg,png',
            'file_surat_tugas' => 'nullable|mimes:jpg,jpeg,png',
            'file_surat_undangan' => 'nullable|mimes:jpg,jpeg,png',
            'file_proposal' => 'nullable|mimes:pdf',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        if ($request->juara == 4) {
            // Validasi: nama_juara wajib jika juara == 4
            $validator = Validator::make($request->all(), [
                'juara' => 'required',
                'nama_juara' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $prestasi->nama_juara = $request->nama_juara;
        } else {
            $prestasi->nama_juara = 'Juara ' . $request->juara;
        }

        $mhs = Auth::user()->mahasiswa;

        $prestasi->juara = $request->juara;
        $prestasi->mahasiswa_id = $mhs->mahasiswa_id;
        $prestasi->dosen_id = $request->dosen_id;
        $prestasi->lomba_id = $request->lomba_id;
        $prestasi->prestasi_nama = $request->prestasi_nama;
        $prestasi->tanggal_perolehan = $request->tanggal_perolehan;


        $nim_mahasiswa = $mhs->nim;

        if ($request->hasFile('file_sertifikat')) {
            self::deleteFile($prestasi->file_sertifikat);
            $prestasi->file_sertifikat = self::saveFile($request, 'sertifikat', $nim_mahasiswa, 'file_sertifikat');
        }

        if ($request->hasFile('file_bukti_foto')) {
            self::deleteFile($prestasi->file_bukti_foto);
            $prestasi->file_bukti_foto = self::saveFile($request, 'bukti_foto', $nim_mahasiswa, 'file_bukti_foto');
        }

        if ($request->hasFile('file_surat_tugas')) {
            self::deleteFile($prestasi->file_surat_tugas);
            $prestasi->file_surat_tugas = self::saveFile($request, 'surat_tugas', $nim_mahasiswa, 'file_surat_tugas');
        }

        if ($request->hasFile('file_surat_undangan')) {
            self::deleteFile($prestasi->file_surat_undangan);
            $prestasi->file_surat_undangan = self::saveFile($request, 'surat_undangan', $nim_mahasiswa, 'file_surat_undangan');
        }

        if ($request->hasFile('file_proposal')) {
            self::deleteFile($prestasi->file_proposal);
            $prestasi->file_proposal = self::saveFile($request, 'proposal', $nim_mahasiswa, 'file_proposal');
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

    public function confirm(PrestasiModel $prestasi)
    {
        return view('mahasiswa.prestasi.confirm_delete_prestasi', compact('prestasi'));
    }
    public function destroy(PrestasiModel $prestasi)
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

    private static function saveFile($requestFile, string $jenis, string $nim_mahasiswa, string $nama_variabel)
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
            $destinationPath = storage_path('app/public/mahasiswa/' . $nim_mahasiswa . '/prestasi/' . $jenis . '/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            // Pindahkan file
            $file->move($destinationPath, $filename);

            $imagePath = "mahasiswa/$nim_mahasiswa/prestasi/$jenis/$filename"; // Simpan path gambar
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

    private static function hitungPoin(PrestasiModel $prestasi)
    {
        $poin = 5;

        return $poin;
    }

}

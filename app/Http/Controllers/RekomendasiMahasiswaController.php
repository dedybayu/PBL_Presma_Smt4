<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use App\Models\RekomendasiMahasiswaLombaModel;
use Carbon\Carbon;
use Doctrine\Inflector\Rules\English\Rules;
use Http;
use Illuminate\Http\Request;
use Log;
use Validator;
use Yajra\DataTables\DataTables;

class RekomendasiMahasiswaController extends Controller
{
    public function index()
    {
        $lomba = LombaModel::where('tanggal_mulai', '>', Carbon::now())
            ->where('status_verifikasi', 1)
            ->get();
        return view('admin.rekomendasi.daftar_rekomendasi')->with('lomba', $lomba);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $query = RekomendasiMahasiswaLombaModel::with([
                'mahasiswa',
                'lomba'
            ]);

            if ($request->lomba_id) {
                $query->where('lomba_id', $request->lomba_id);
            }

            $bidangKeahlian = $query->get();

            return DataTables::of($bidangKeahlian)
                ->addIndexColumn()
                ->addColumn('nama_lomba', function ($row) {
                    return $row->lomba->lomba_nama;
                })
                ->addColumn('rekomendasi_mahasiswa', function ($row) {
                    return $row->mahasiswa->nama;
                })
                ->addColumn('nim', function ($row) {
                    return $row->mahasiswa->nim;
                })
                ->addColumn('rank', function ($row) {
                    return $row->rank;
                })

                ->make(true);
        }
    }

    public function show_refresh()
    {
        return view('admin.rekomendasi.refresh_rekomendasi');
    }

    public function refresh(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'metode' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Metode harus dipilih.',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                if ($request->metode == 'topsis') {
                    $this->rekomendasiByTopsis();
                } elseif ($request->metode == 'saw') {
                    $this->rekomendasiBySAW();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data rekomendasi berhasil di perbarui.'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data rekomendasi gagal di perbarui. ' . $th->getMessage()
                ]);
            }

        }
    }

    public function confirm()
    {
        return view('admin.rekomendasi.confirm_delete_rekomendasi');
    }

    public function destroy()
    {
        RekomendasiMahasiswaLombaModel::truncate();
        return response()->json([
            'status' => true,
            'message' => 'Data rekomendasi berhasil di hapus.'
        ]);
    }

    // KRITERIA

    //IPK
    //Keahlian
    //Jumlah Prestasi
    //Tingkat lomba prestasi
    //Poin Prestasi
    //Bidang Prestasi 
    //Minat
    //Organisasi


    public static function rekomendasiByTopsis()
    {
        $allLomba = LombaModel::with([
            'bidang.kategoriBidangKeahlian',
            'penyelenggara.kota.provinsi.negara',
            'tingkat'
        ])
            ->where('tanggal_mulai', '>', Carbon::now())
            ->where('status_verifikasi', 1)
            ->get();
        // dd($allLomba);

        RekomendasiMahasiswaLombaModel::truncate();

        foreach ($allLomba as $lomba) {
            if ($lomba[0] || $lomba[1]) {
                continue;
            }
            $response = Http::post('http://127.0.0.1:8000/api/topsis', [
                "jumlah_anggota" => $lomba->jumlah_anggota,
                "bobot" => self::getBobot($lomba),
                // "bobot" => [0.15, 0.1, 0.15, 0.2, 0.1, 0.1, 0.1, 0.1],
                "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
                "mahasiswa" => self::getAlternatif($lomba)
            ]);

            if ($response->successful()) {
                foreach ($response->json() as $mahasiswa) {
                    // dd($mahasiswa[ra]);
                    RekomendasiMahasiswaLombaModel::create([
                        "mahasiswa_id" => $mahasiswa['mahasiswa_id'],
                        "lomba_id" => $lomba->lomba_id,
                        "rank" => $mahasiswa['rank']
                    ]);
                }
            } else {
                Log::error('Gagal mendapatkan data dari TOPSIS API', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        }
    }
    public static function rekomendasiBySAW()
    {
        $allLomba = LombaModel::with([
            'bidang.kategoriBidangKeahlian',
            'penyelenggara.kota.provinsi.negara',
            'tingkat'
        ])
            ->where('tanggal_mulai', '>', Carbon::now())
            ->where('status_verifikasi', 1)
            ->get();
        // dd($allLomba);

        RekomendasiMahasiswaLombaModel::truncate();

        foreach ($allLomba as $lomba) {
            $response = Http::post('http://127.0.0.1:8000/api/saw', [
                "jumlah_anggota" => $lomba->jumlah_anggota,
                // "bobot" => [0.15, 0.1, 0.15, 0.2, 0.1, 0.1, 0.1, 0.1],
                "bobot" => self::getBobot($lomba),
                "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
                "mahasiswa" => self::getAlternatif($lomba)
            ]);

            if ($response->successful()) {
                foreach ($response->json() as $mahasiswa) {
                    // dd($mahasiswa[ra]);
                    RekomendasiMahasiswaLombaModel::create([
                        "mahasiswa_id" => $mahasiswa['mahasiswa_id'],
                        "lomba_id" => $lomba->lomba_id,
                        "rank" => $mahasiswa['rank']
                    ]);
                }
            } else {
                Log::error('Gagal mendapatkan data dari TOPSIS API', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        }
    }

    public static function getBobot(LombaModel $lomba)
    {
        $response = Http::post('http://127.0.0.1:8000/api/psi', [
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
            "mahasiswa" => self::getAlternatif($lomba)
        ]);

        if ($response->successful()) {
            $bobot = $response->json()['bobot'];
            // Misalnya ingin mencetak atau memproses bobotnya
            return $bobot;
        } else {
            Log::error('Gagal menghitung bobot dengan PSI', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
    }
    public static function kalkulasiBobot__(LombaModel $lomba)
    {
        $allLomba = LombaModel::with([
            'bidang.kategoriBidangKeahlian',
            'penyelenggara.kota.provinsi.negara',
            'tingkat'
        ])
            ->where('tanggal_selesai', '<', Carbon::now())
            ->where('status_verifikasi', 1)
            ->get();

        $response = Http::post('http://127.0.0.1:8000/api/psi', [
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
            "mahasiswa" => self::getAlternatif($allLomba[0])
        ]);

        if ($response->successful()) {
            $bobot = $response->json()['bobot'];
            // Misalnya ingin mencetak atau memproses bobotnya
            dd($bobot);
        } else {
            Log::error('Gagal menghitung bobot dengan PSI', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
    }


    private static function getAlternatif(LombaModel $lomba)
    {
        $allMahasiswa = MahasiswaModel::with(
            'prestasi.lomba.bidang.kategoriBidangKeahlian',
            'prestasi.lomba.tingkat',
            'prestasi.lomba.penyelenggara.kota.provinsi.negara',
            'minat',
            'keahlian.bidang_keahlian.kategoriBidangKeahlian',
            'organisasi'
        )->get();

        $allternatif = [];
        foreach ($allMahasiswa as $mahasiswa) {
            $allternatif[] = [
                "mahasiswa_id" => $mahasiswa->mahasiswa_id,
                "ipk" => $mahasiswa->ipk,
                "keahlian" => self::kesesuaianKeahlian($mahasiswa->keahlian, $lomba->bidang),
                "jumlah_prestasi" => count($mahasiswa->prestasi),
                "kesesuaian_bidang_prestasi" => self::kesesuaianBidangPrestasi($mahasiswa->prestasi, $lomba->bidang),
                "tingkat_lomba_prestasi" => self::tingkatLombaPrestasi($mahasiswa->prestasi),
                "poin_prestasi" => self::totalPoinMahasiswa($mahasiswa->prestasi),
                "minat" => self::kesesuaianMinat($mahasiswa->minat, $lomba->bidang),
                "organisasi" => count($mahasiswa->organisasi)
            ];
        }
        return $allternatif;
    }

    private static function totalPoinMahasiswa($listPrestasimahasiswa)
    {
        $totalPoin = 0;
        foreach ($listPrestasimahasiswa as $prestasi) {
            if ($prestasi->status_verifikasi === 1) {
                $totalPoin += $prestasi->poin;
            }
        }
        return $totalPoin;
    }

    private static function kesesuaianKeahlian($listKeahlian, BidangKeahlianModel $bidangKeahlian)
    {
        // dd($bidangKeahlian);
        $poin = 0;
        if ($listKeahlian->isEmpty()) {
            // dd('null'); // Tidak ada keahlian mahasiswa
        } else {
            foreach ($listKeahlian as $keahlian) {
                if ($keahlian->bidang_keahlian_id === $bidangKeahlian->bidang_keahlian_id) {
                    $poin += 100;
                } else {
                    $keahlian->bidang_keahlian->kategoriBidangKeahlian->kategori_bidang_keahlian_id === $bidangKeahlian->kategoriBidangKeahlian->kategori_bidang_keahlian_id ? $poin += 65 : $poin += 10;
                }
            }
        }

        // dd($poin); // Debug isi
        return $poin;
    }

    private static function kesesuaianMinat($listMinat, BidangKeahlianModel $bidangKeahlian)
    {
        // dd($bidangKeahlian);
        $poin = 0;
        if ($listMinat->isEmpty()) {
            // dd('null'); // Tidak ada keahlian mahasiswa
        } else {
            foreach ($listMinat as $minat) {
                if ($minat->bidang_keahlian_id === $bidangKeahlian->bidang_keahlian_id) {
                    $poin += 100;
                } else {
                    $minat->bidang_keahlian->kategoriBidangKeahlian->kategori_bidang_keahlian_id === $bidangKeahlian->kategoriBidangKeahlian->kategori_bidang_keahlian_id ? $poin += 65 : $poin += 10;
                }
            }
        }

        // dd($poin); // Debug isi
        return $poin;
    }

    private static function kesesuaianBidangPrestasi($ListrestasiMahasiswa, BidangKeahlianModel $bidangKeahlian)
    {
        // dd($bidangKeahlian);
        $poin = 0;
        if ($ListrestasiMahasiswa->isEmpty()) {
            // dd('null'); // Tidak ada keahlian mahasiswa
        } else {
            foreach ($ListrestasiMahasiswa as $prestasi) {
                if ($prestasi->status_verifikasi === 0) {
                    continue;
                }
                if ($prestasi->lomba->bidang->bidang_keahlian_id === $bidangKeahlian->bidang_keahlian_id) {
                    $poin += 100;
                } else {
                    $prestasi->lomba->bidang->kategoriBidangKeahlian->kategori_bidang_keahlian_id === $bidangKeahlian->kategoriBidangKeahlian->kategori_bidang_keahlian_id ? $poin += 65 : $poin += 10;
                }
            }
        }

        // dd($poin); // Debug isi
        return $poin;
    }

    private static function tingkatLombaPrestasi($listPrestasiMahasiswa)
    {
        $prioritas = [
            'INT' => 100, // Internasional
            'NAS' => 60,  // Nasional
            'PRO' => 30,  // Provinsi
            'KAB' => 10   // Kabupaten
        ];
        $poin = 0;
        foreach ($prioritas as $kode => $poin) {
            foreach ($listPrestasiMahasiswa as $prestasi) {
                if (
                    $prestasi->status_verifikasi === 1 &&
                    $prestasi->lomba &&
                    $prestasi->lomba->tingkat &&
                    $prestasi->lomba->tingkat->tingkat_lomba_kode === $kode
                ) {
                    return $poin; // return saat menemukan tingkat tertinggi
                }
            }
        }
        return 0; // Jika tidak ada prestasi terverifikasi
    }




    public function python()
    {
        // return 'hello';
        // $lomba = LombaModel::all();

        // $response = Http::get('http://127.0.0.1:8000/api/data');
        // return $response->json()['message'];


        $lomba = LombaModel::find(1)->with('bidang', 'penyelenggara.kota.provinsi.negara', 'tingkat')->first();
        $mahasiswa = MahasiswaModel::all();

        // Ubah ke array agar bisa dikirim sebagai JSON
        $lombaData = $lomba->toArray();
        $mahasiswaData = $mahasiswa->toArray();

        // Kirim via POST ke FastAPI
        $response = Http::post('http://127.0.0.1:8000/api/data', [
            'lomba' => $lombaData,
            'mahasiswa' => $mahasiswaData
        ]);

        // Ambil data respons
        return $response->json(); // atau ['data'] tergantung isi respons FastAPI
    }


    public function python_coba()
    {
        $response = Http::post('http://127.0.0.1:8000/api/topsis', [
            "bobot" => [0.15, 0.1, 0.15, 0.1, 0.1, 0.1, 0.1, 0.1],
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
            "mahasiswa" => [
                [
                    "mahasiswa_id" => 1,
                    "ipk" => 3.7,
                    "keahlian" => 6,
                    "jumlah_prestasi" => 4,
                    "kesesuaian_bidang_prestasi" => 6,
                    "tingkat_lomba_prestasi" => 2,
                    "poin_prestasi" => 200,
                    "minat" => 2,
                    "organisasi" => 75
                ],
                [
                    "mahasiswa_id" => 2,
                    "ipk" => 3.5,
                    "keahlian" => 5,
                    "jumlah_prestasi" => 6,
                    "kesesuaian_bidang_prestasi" => 4,
                    "tingkat_lomba_prestasi" => 2,
                    "poin_prestasi" => 250,
                    "minat" => 2,
                    "organisasi" => 65
                ],
                [
                    "mahasiswa_id" => 3,
                    "ipk" => 3.85,
                    "keahlian" => 8,
                    "jumlah_prestasi" => 8,
                    "kesesuaian_bidang_prestasi" => 8,
                    "tingkat_lomba_prestasi" => 4,
                    "poin_prestasi" => 350,
                    "minat" => 1,
                    "organisasi" => 90
                ],
                [
                    "mahasiswa_id" => 4,
                    "ipk" => 3.3,
                    "keahlian" => 3,
                    "jumlah_prestasi" => 2,
                    "kesesuaian_bidang_prestasi" => 2,
                    "tingkat_lomba_prestasi" => 1,
                    "poin_prestasi" => 100,
                    "minat" => 3,
                    "organisasi" => 50
                ],
                [
                    "mahasiswa_id" => 5,
                    "ipk" => 3.6,
                    "keahlian" => 6,
                    "jumlah_prestasi" => 5,
                    "kesesuaian_bidang_prestasi" => 7,
                    "tingkat_lomba_prestasi" => 3,
                    "poin_prestasi" => 280,
                    "minat" => 2,
                    "organisasi" => 85
                ]
            ]
        ]);


        return $response->json(); // bisa juga ->body() untuk raw response
    }

    // KRITERIA

    //IPK
    //Keahlian
    //Jumlah Prestasi
    //Tingkat lomba prestasi
    //Poin Prestasi
    //Bidang Prestasi 
    //Minat
    //Organisasi


}

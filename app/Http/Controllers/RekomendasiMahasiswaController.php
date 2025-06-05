<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use Http;
use Illuminate\Http\Request;

class RekomendasiMahasiswaController extends Controller
{
    // KRITERIA

    //IPK
    //Keahlian
    //Jumlah Prestasi
    //Tingkat lomba prestasi
    //Poin Prestasi
    //Bidang Prestasi 
    //Minat
    //Organisasi

    public function rekomendasiByTopsis()
    {
        $lomba = LombaModel::find(1)->with('bidang', 'penyelenggara.kota.provinsi.negara', 'tingkat')->first();
        // dd(self::getAlternatif($lomba));
        $bidang = $lomba->bidang;
        $response = Http::post('http://127.0.0.1:8000/api/topsis', [
            "bobot" => [0.15, 0.1, 0.15, 0.2, 0.1, 0.1, 0.1, 0.1],
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
            "mahasiswa" => self::getAlternatif($lomba)

        ]);

        return $response->json();
    }

    private static function getAlternatif(LombaModel $lomba)
    {
        $allMahasiswa = MahasiswaModel::with(
            'prestasi.lomba.bidang.kategoriBidangKeahlian',
            'prestasi.lomba.tingkat',
            'prestasi.lomba.penyelenggara.kota.provinsi.negara',
            'minat',
            'keahlian',
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
        return 5;
    }
    private static function kesesuaianMinat($listMinat, BidangKeahlianModel $bidangKeahlian)
    {
        return 5;
    }

    private static function kesesuaianBidangPrestasi($ListrestasiMahasiswa, BidangKeahlianModel $bidangKeahlian)
    {
        return 5;
    }

    private static function tingkatLombaPrestasi($listPrestasiMahasiswa)
    {
        return 5;
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

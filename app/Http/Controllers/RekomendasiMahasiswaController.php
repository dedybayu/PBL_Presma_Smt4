<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use Http;
use Illuminate\Http\Request;

class RekomendasiMahasiswaController extends Controller
{
    public function rekomendasiByTopsis(LombaModel $lomba)
    {
        $bidang = $lomba->bidang;
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
            "bobot" => [0.15, 0.1, 0.15, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1],
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit", "benefit"],
            "mahasiswa" => [
                [
                    "mahasiswa_id" => 1,
                    "ipk" => 3.7,
                    "keahlian" => 6,
                    "jumlah_prestasi" => 4,
                    "kesesuaian_bidang_prestasi" => 6,
                    "tingkat_lomba_prestasi" => 2,
                    "poin_prestasi" => 200,
                    "bidang" => 1,
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
                    "bidang" => 3,
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
                    "bidang" => 2,
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
                    "bidang" => 1,
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
                    "bidang" => 2,
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

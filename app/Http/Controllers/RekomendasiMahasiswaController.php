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
                    "nama" => "A",
                    "ipk" => 3.8,
                    "keahlian" => 7,
                    "jumlah_prestasi" => 7,
                    "kesesuaian_bidang_prestasi" => 7,
                    "tingkat_lomba_prestasi" => 3,
                    "poin_prestasi" => 300,
                    "bidang" => 2,
                    "minat" => 1,
                    "organisasi" => 80
                ],
                [
                    "nama" => "B",
                    "ipk" => 3.9,
                    "keahlian" => 4,
                    "jumlah_prestasi" => 5,
                    "kesesuaian_bidang_prestasi" => 5,
                    "tingkat_lomba_prestasi" => 3,
                    "poin_prestasi" => 300,
                    "bidang" => 2,
                    "minat" => 1,
                    "organisasi" => 80
                ],
                
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

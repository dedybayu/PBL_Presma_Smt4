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
            "bobot" => [0.25, 0.2, 0.2, 0.15, 0.2],
            "kriteria" => ["benefit", "benefit", "benefit", "benefit", "cost"],
            "mahasiswa" => [
                [
                    "nama" => "A",
                    "ipk" => 3.8,
                    "presentasi" => 85,
                    "pengalaman" => 4,
                    "organisasi" => 80,
                    "biaya" => 500
                ],
                [
                    "nama" => "B",
                    "ipk" => 3.5,
                    "presentasi" => 80,
                    "pengalaman" => 6,
                    "organisasi" => 70,
                    "biaya" => 300
                ],
                [
                    "nama" => "C",
                    "ipk" => 3.9,
                    "presentasi" => 90,
                    "pengalaman" => 3,
                    "organisasi" => 85,
                    "biaya" => 450
                ],
                [
                    "nama" => "D",
                    "ipk" => 3.6,
                    "presentasi" => 88,
                    "pengalaman" => 5,
                    "organisasi" => 75,
                    "biaya" => 350
                ]
            ]
        ]);

        return $response->json(); // bisa juga ->body() untuk raw response
    }
}

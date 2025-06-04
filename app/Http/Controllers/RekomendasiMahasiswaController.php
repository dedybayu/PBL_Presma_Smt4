<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
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
        // $lomba = LombaModel::all();

        // $response = Http::get('http://127.0.0.1:8000/api/data');
        // return $response->json()['message'];


        $lomba = LombaModel::all();

        // Ubah ke array agar bisa dikirim sebagai JSON
        $lombaData = $lomba->toArray();

        // Kirim via POST ke FastAPI
        $response = Http::post('http://127.0.0.1:8000/api/data', [
            'lomba' => $lombaData
        ]);

        // Ambil data respons
        return $response->json(); // atau ['data'] tergantung isi respons FastAPI
    }

}

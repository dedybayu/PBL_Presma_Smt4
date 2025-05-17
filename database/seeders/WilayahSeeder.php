<?php

namespace Database\Seeders;

use App\Models\KotaModel;
use App\Models\NegaraModel;
use App\Models\ProvinsiModel;
use Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indonesia = NegaraModel::where('negara_kode', 'ID')->first();

        // Ambil data provinsi dari API Emsifa
        $provinsiResponse = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');

        if ($provinsiResponse->successful()) {
            $provinsis = $provinsiResponse->json();

            foreach ($provinsis as $provinsiData) {
                // Simpan data provinsi
                $provinsi = ProvinsiModel::firstOrCreate([
                    'provinsi_nama' => $provinsiData['name'],
                    'negara_id' => $indonesia->negara_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Ambil data kota/kabupaten berdasarkan ID provinsi
                $kotaResponse = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinsiData['id']}.json");

                if ($kotaResponse->successful()) {
                    $kotas = $kotaResponse->json();

                    foreach ($kotas as $kotaData) {
                        // Simpan data kota/kabupaten
                        KotaModel::firstOrCreate([
                            'kota_nama' => ucwords(strtolower($kotaData['name'])), 
                            'provinsi_id' => $provinsi->provinsi_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                            ]);
                    }
                }
            }
        }
    }
}

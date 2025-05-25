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
                    'provinsi_nama' => ucwords(strtolower($provinsiData['name'])),
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

        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,cca2,capital');

        if ($response->successful()) {
            $countries = $response->json();

            foreach ($countries as $country) {
                if ($country['cca2'] === 'ID') {
                    continue;
                }
                
                $negara = NegaraModel::where('negara_kode', $country['cca2'])->first();

                if ($negara) {
                    $provNegara = ProvinsiModel::firstOrCreate(
                        [
                            'provinsi_nama' => ucwords(strtolower($country['name']['common'])),
                            'negara_id' => $negara->negara_id,
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    // Ambil ibu kota jika tersedia
                    $capitalName = isset($country['capital'][0]) ? ucwords(strtolower($country['capital'][0])) : null;

                    if ($capitalName) {
                        KotaModel::firstOrCreate(
                            [
                                'kota_nama' => $capitalName,
                                'provinsi_id' => $provNegara->provinsi_id,
                            ],
                            [
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        );
                    }
                }
            }
        } else {
            $this->command->error('Gagal mengambil data negara dari API.');
        }


    }
}

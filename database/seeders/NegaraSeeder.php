<?php

namespace Database\Seeders;

use App\Models\NegaraModel;
use Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,cca2');

        if ($response->successful()) {
            $countries = $response->json();

            foreach ($countries as $country) {
                NegaraModel::updateOrCreate(
                    ['negara_kode' => $country['cca2']],
                    [
                        'negara_nama' => $country['name']['common'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } else {
            $this->command->error('Gagal mengambil data negara dari API.');
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil seluruh kelas_id berdasarkan kelas_kode
        $kelas = KelasModel::all()->pluck('kelas_id', 'kelas_kode');

        $mahasiswaData = [];

        // Membuat data mahasiswa random
        for ($i = 1; $i <= 10; $i++) { // Ganti 10 sesuai jumlah data yang diinginkan
            // Pilih kelas_id berdasarkan kelas_kode secara acak
            $kelasKode = array_rand($kelas->toArray()); 
            $kelasId = $kelas[$kelasKode];

            $mahasiswaData[] = [
                'nim' => $faker->unique()->numerify('2023########'),
                'password' => 'mahasiswa123',
                'nama' => $faker->firstName . ' ' . $faker->lastName,
                'kelas_id' => $kelasId,
                'no_tlp' => $faker->unique()->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'alamat' => $faker->address,
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data mahasiswa ke tabel
        MahasiswaModel::insert($mahasiswaData);
    }
}

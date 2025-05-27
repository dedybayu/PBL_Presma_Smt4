<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'organisasi_kode' => 'HMJ',
                'organisasi_nama' => 'Himpunan Mahasiswa Jurusan',
            ],
            [
                'organisasi_kode' => 'UKM',
                'organisasi_nama' => 'Unit Kegiatan Mahasiswa',
            ],
            [
                'organisasi_kode' => 'BEM',
                'organisasi_nama' => 'Badan Eksekutif Mahasiswa',
            ],
            [
                'organisasi_kode' => 'OLK',
                'organisasi_nama' => 'Organisasi Luar Kampus',
            ],
        ];
    }
}

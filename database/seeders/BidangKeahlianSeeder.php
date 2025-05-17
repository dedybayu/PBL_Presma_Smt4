<?php

namespace Database\Seeders;

use App\Models\BidangKeahlianModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangKeahlianModel::insert([
            [
                'bidang_keahlian_kode' => 'DES',
                'bidang_keahlian_nama' => 'Design',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'PRO',
                'bidang_keahlian_nama' => 'Programming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'WEB',
                'bidang_keahlian_nama' => 'Web Development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'GAM',
                'bidang_keahlian_nama' => 'Game Development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'NET',
                'bidang_keahlian_nama' => 'Networking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'SEC',
                'bidang_keahlian_nama' => 'Cyber Security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'DBA',
                'bidang_keahlian_nama' => 'Database Administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'MLA',
                'bidang_keahlian_nama' => 'Machine Learning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'AIK',
                'bidang_keahlian_nama' => 'Artificial Intelligence',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'CLD',
                'bidang_keahlian_nama' => 'Cloud Computing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'UXD',
                'bidang_keahlian_nama' => 'UI/UX Design',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'MOB',
                'bidang_keahlian_nama' => 'Mobile Development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'IOT',
                'bidang_keahlian_nama' => 'Internet of Things',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'ROB',
                'bidang_keahlian_nama' => 'Robotics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'DSC',
                'bidang_keahlian_nama' => 'Data Science',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'BDA',
                'bidang_keahlian_nama' => 'Big Data Analytics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'SWE',
                'bidang_keahlian_nama' => 'Software Engineering',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'TST',
                'bidang_keahlian_nama' => 'Software Testing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'VRR',
                'bidang_keahlian_nama' => 'Virtual Reality',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bidang_keahlian_kode' => 'BLC',
                'bidang_keahlian_nama' => 'Blockchain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}

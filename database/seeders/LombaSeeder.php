<?php

namespace Database\Seeders;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$tingkatLomba = TingkatLombaModel::pluck('tingkat_lomba_id')->values();
        $bidangKeahlian = BidangKeahlianModel::pluck('bidang_keahlian_id')->values();
        $penyelenggara = PenyelenggaraModel::pluck('penyelenggara_id')->values();

        $lombaData = [
            [
                'lomba_kode' => 'LMB001',
                'lomba_nama' => 'Hackathon Nasional',
                'tingkat_lomba_id' => $tingkatLomba[1],
                'bidang_keahlian_id' => $bidangKeahlian[1],
                'penyelenggara_id' => $penyelenggara[0],
                'tanggal_mulai' => '2025-03-01',
                'tanggal_selesai' => '2025-03-03',
            ],
            [
                'lomba_kode' => 'LMB002',
                'lomba_nama' => 'UI/UX Challenge',
                'tingkat_lomba_id' => $tingkatLomba[0],
                'bidang_keahlian_id' => $bidangKeahlian[0],
                'penyelenggara_id' => $penyelenggara[1],
                'tanggal_mulai' => '2025-04-05',
                'tanggal_selesai' => '2025-04-06',
            ],
            [
                'lomba_kode' => 'LMB003',
                'lomba_nama' => 'Web Development Competition',
                'tingkat_lomba_id' => $tingkatLomba[1],
                'bidang_keahlian_id' => $bidangKeahlian[2],
                'penyelenggara_id' => $penyelenggara[2],
                'tanggal_mulai' => '2025-02-10',
                'tanggal_selesai' => '2025-02-12',
            ],
            [
                'lomba_kode' => 'LMB004',
                'lomba_nama' => 'Mobile App Contest',
                'tingkat_lomba_id' => $tingkatLomba[1],
                'bidang_keahlian_id' => $bidangKeahlian[1],
                'penyelenggara_id' => $penyelenggara[0],
                'tanggal_mulai' => '2025-05-01',
                'tanggal_selesai' => '2025-05-03',
            ],
            [
                'lomba_kode' => 'LMB005',
                'lomba_nama' => 'IT Project Management Cup',
                'tingkat_lomba_id' => $tingkatLomba[2],
                'bidang_keahlian_id' => $bidangKeahlian[4],
                'penyelenggara_id' => $penyelenggara[1],
                'tanggal_mulai' => '2025-06-10',
                'tanggal_selesai' => '2025-06-12',
            ],
            [
                'lomba_kode' => 'LMB006',
                'lomba_nama' => 'Cybersecurity Championship',
                'tingkat_lomba_id' => $tingkatLomba[1],
                'bidang_keahlian_id' => $bidangKeahlian[3],
                'penyelenggara_id' => $penyelenggara[2],
                'tanggal_mulai' => '2025-07-20',
                'tanggal_selesai' => '2025-07-22',
            ],
            [
                'lomba_kode' => 'LMB007',
                'lomba_nama' => 'AI Innovation Contest',
                'tingkat_lomba_id' => $tingkatLomba[0],
                'bidang_keahlian_id' => $bidangKeahlian[5],
                'penyelenggara_id' => $penyelenggara[0],
                'tanggal_mulai' => '2025-08-15',
                'tanggal_selesai' => '2025-08-16',
            ],
            [
                'lomba_kode' => 'LMB008',
                'lomba_nama' => 'Game Development Festival',
                'tingkat_lomba_id' => $tingkatLomba[2],
                'bidang_keahlian_id' => $bidangKeahlian[3],
                'penyelenggara_id' => $penyelenggara[1],
                'tanggal_mulai' => '2025-09-01',
                'tanggal_selesai' => '2025-09-04',
            ],
            [
                'lomba_kode' => 'LMB009',
                'lomba_nama' => 'Data Science Competition',
                'tingkat_lomba_id' => $tingkatLomba[1],
                'bidang_keahlian_id' => $bidangKeahlian[6],
                'penyelenggara_id' => $penyelenggara[2],
                'tanggal_mulai' => '2025-10-10',
                'tanggal_selesai' => '2025-10-12',
            ],
            [
                'lomba_kode' => 'LMB010',
                'lomba_nama' => 'Robotic Engineering Challenge',
                'tingkat_lomba_id' => $tingkatLomba[0],
                'bidang_keahlian_id' => $bidangKeahlian[7],
                'penyelenggara_id' => $penyelenggara[0],
                'tanggal_mulai' => '2025-11-20',
                'tanggal_selesai' => '2025-11-22',
            ],
        ];

        foreach ($lombaData as &$data) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['status_verifikasi'] = true;
        }

        LombaModel::insert($lombaData);
    }
}

<?php

namespace Database\Seeders;

use App\Models\AdminModel;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminModel::create([
            'username' => 'admin',
            'password' => 'admin123',
            'nama' => 'Administrator',
            'email' => 'admin@example.com',
            'no_tlp' => '081234567890',
            'foto_profile' => null,
        ]);
    }
}

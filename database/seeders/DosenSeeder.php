<?php

namespace Database\Seeders;

use App\Models\DosenModel;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Gunakan lokal Indonesia

        for ($i = 1; $i <= 20; $i++) {
            DosenModel::create([
                'nidn' => 'NIDN' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'no_tlp' => $faker->phoneNumber,
                'foto_profile' => null,
            ]);
        }
    }
}

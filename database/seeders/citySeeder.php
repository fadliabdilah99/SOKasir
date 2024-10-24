<?php

namespace Database\Seeders;

use App\Models\city;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class citySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filekota = file_get_contents(base_path('/database/kota.json'));
        $filekabupaten = file_get_contents(base_path('/database/kabupaten.json'));
        $datakota = json_decode($filekota, true);
        $datakabupaten = json_decode($filekabupaten, true);

        city::insert($datakabupaten);
        city::insert($datakota);
    }
}

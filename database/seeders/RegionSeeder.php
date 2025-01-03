<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_region')->truncate();
        $csvFileCity = fopen(base_path("database/data/regencies.csv"), "r");
        while (($data = fgetcsv($csvFileCity)) !== false){
            DB::table('m_region')->insert(["name" => $data[2]]);
        }
    }
}

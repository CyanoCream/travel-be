<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subdistricts = [
            // Banda Aceh (cities_id = 1)
            ['name' => 'Baiturrahman', 'cities_id' => 1],
            ['name' => 'Kuta Alam', 'cities_id' => 1],
            ['name' => 'Meuraxa', 'cities_id' => 1],

            // Langsa (cities_id = 2)
            ['name' => 'Langsa Kota', 'cities_id' => 2],
            ['name' => 'Langsa Lama', 'cities_id' => 2],
            ['name' => 'Langsa Baro', 'cities_id' => 2],

            // Medan (cities_id = 7)
            ['name' => 'Medan Baru', 'cities_id' => 7],
            ['name' => 'Medan Tuntungan', 'cities_id' => 7],
            ['name' => 'Medan Timur', 'cities_id' => 7],

            // Padang (cities_id = 13)
            ['name' => 'Padang Barat', 'cities_id' => 13],
            ['name' => 'Padang Timur', 'cities_id' => 13],
            ['name' => 'Padang Utara', 'cities_id' => 13],

            // Jakarta Pusat (cities_id = 17)
            ['name' => 'Gambir', 'cities_id' => 17],
            ['name' => 'Menteng', 'cities_id' => 17],
            ['name' => 'Tanah Abang', 'cities_id' => 17],

            // Bandung (cities_id = 18)
            ['name' => 'Cicendo', 'cities_id' => 18],
            ['name' => 'Sukajadi', 'cities_id' => 18],
            ['name' => 'Cibiru', 'cities_id' => 18],

            // Semarang (cities_id = 23)
            ['name' => 'Banyumanik', 'cities_id' => 23],
            ['name' => 'Candisari', 'cities_id' => 23],
            ['name' => 'Gajahmungkur', 'cities_id' => 23],

            // Surabaya (cities_id = 29)
            ['name' => 'Wonokromo', 'cities_id' => 29],
            ['name' => 'Sukolilo', 'cities_id' => 29],
            ['name' => 'Tegalsari', 'cities_id' => 29],

            // Denpasar (cities_id = 33)
            ['name' => 'Denpasar Barat', 'cities_id' => 33],
            ['name' => 'Denpasar Timur', 'cities_id' => 33],
            ['name' => 'Denpasar Selatan', 'cities_id' => 33],

            // Makassar (cities_id = 41)
            ['name' => 'Tamalanrea', 'cities_id' => 41],
            ['name' => 'Panakkukang', 'cities_id' => 41],
            ['name' => 'Ujung Pandang', 'cities_id' => 41],

            // Jayapura (cities_id = 45)
            ['name' => 'Jayapura Utara', 'cities_id' => 45],
            ['name' => 'Jayapura Selatan', 'cities_id' => 45],
        ];

        DB::table('tbl_subdistrict')->insert($subdistricts);
    }
}

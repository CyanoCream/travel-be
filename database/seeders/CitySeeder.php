<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            // Aceh (province_id = 1)
            ['name' => 'Banda Aceh', 'province_id' => 1],
            ['name' => 'Langsa', 'province_id' => 1],
            ['name' => 'Lhokseumawe', 'province_id' => 1],
            ['name' => 'Meulaboh', 'province_id' => 1],
            ['name' => 'Sabang', 'province_id' => 1],
            ['name' => 'Subulussalam', 'province_id' => 1],

            // Sumatera Utara (province_id = 2)
            ['name' => 'Medan', 'province_id' => 2],
            ['name' => 'Binjai', 'province_id' => 2],
            ['name' => 'Pematangsiantar', 'province_id' => 2],
            ['name' => 'Tebing Tinggi', 'province_id' => 2],
            ['name' => 'Sibolga', 'province_id' => 2],
            ['name' => 'Gunungsitoli', 'province_id' => 2],

            // Sumatera Barat (province_id = 3)
            ['name' => 'Padang', 'province_id' => 3],
            ['name' => 'Bukittinggi', 'province_id' => 3],
            ['name' => 'Payakumbuh', 'province_id' => 3],
            ['name' => 'Pariaman', 'province_id' => 3],
            ['name' => 'Sawahlunto', 'province_id' => 3],

            // DKI Jakarta (province_id = 11)
            ['name' => 'Jakarta Pusat', 'province_id' => 11],
            ['name' => 'Jakarta Utara', 'province_id' => 11],
            ['name' => 'Jakarta Barat', 'province_id' => 11],
            ['name' => 'Jakarta Selatan', 'province_id' => 11],
            ['name' => 'Jakarta Timur', 'province_id' => 11],

            // Jawa Barat (province_id = 12)
            ['name' => 'Bandung', 'province_id' => 12],
            ['name' => 'Bogor', 'province_id' => 12],
            ['name' => 'Bekasi', 'province_id' => 12],
            ['name' => 'Depok', 'province_id' => 12],
            ['name' => 'Cimahi', 'province_id' => 12],

            // Jawa Tengah (province_id = 13)
            ['name' => 'Semarang', 'province_id' => 13],
            ['name' => 'Surakarta', 'province_id' => 13],
            ['name' => 'Magelang', 'province_id' => 13],
            ['name' => 'Pekalongan', 'province_id' => 13],
            ['name' => 'Tegal', 'province_id' => 13],

            // Jawa Timur (province_id = 15)
            ['name' => 'Surabaya', 'province_id' => 15],
            ['name' => 'Malang', 'province_id' => 15],
            ['name' => 'Kediri', 'province_id' => 15],
            ['name' => 'Blitar', 'province_id' => 15],
            ['name' => 'Madiun', 'province_id' => 15],

            // Bali (province_id = 17)
            ['name' => 'Denpasar', 'province_id' => 17],

            // Kalimantan Selatan (province_id = 22)
            ['name' => 'Banjarmasin', 'province_id' => 22],
            ['name' => 'Banjarbaru', 'province_id' => 22],

            // Sulawesi Selatan (province_id = 27)
            ['name' => 'Makassar', 'province_id' => 27],
            ['name' => 'Parepare', 'province_id' => 27],
            ['name' => 'Palopo', 'province_id' => 27],

            // Papua (province_id = 33)
            ['name' => 'Jayapura', 'province_id' => 33],
        ];

        DB::table('tbl_cities')->insert($cities);
    }
}

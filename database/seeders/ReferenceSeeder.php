<?php

namespace Database\Seeders;

use App\Models\Master\Reference;
use Illuminate\Database\Seeder;

class ReferenceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Reference::query()->truncate();
        $data_ref = [];
        $data_ref[] = [
            'code' => "PL006",
            'type' => "SUBSCRIPTION",
            'sub_type' => null,
            'value' => 6,
            'description' => "Paket 6 Bulan",
            'attributes' => null
        ];
        $data_ref[] = [
            'code' => "PL012",
            'type' => "SUBSCRIPTION",
            'sub_type' => null,
            'value' => 12,
            'description' => "Paket 1 Tahun",
            'attributes' => null
        ];
        $data_ref[] = [
            'code' => "PD001",
            'type' => "PHOTO_DEFAULT",
            'sub_type' => "MANAGEMENT",
            'value' => null,
            'description' => "Foto default untuk management",
            'attributes' => null
        ];
        $data_ref[] = [
            'code' => "PD002",
            'type' => "PHOTO_DEFAULT",
            'sub_type' => "USER",
            'value' => null,
            'description' => "Foto default untuk user",
            'attributes' => null
        ];
        Reference::query()->insert($data_ref);
    }
}

<?php

namespace Database\Seeders;

use App\Models\TravelSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelScheduleSeeder extends Seeder
{
    public function run()
    {
        $destinations = [
            'Jakarta - Bandung',
            'Bandung - Jakarta',
            'Jakarta - Semarang',
            'Semarang - Jakarta',
            'Jakarta - Surabaya',
            'Surabaya - Jakarta',
            'Bandung - Surabaya',
            'Surabaya - Bandung'
        ];

        foreach ($destinations as $destination) {
            // Create schedules for the next 7 days
            for ($i = 1; $i <= 7; $i++) {
                $departureDateTime = now()->addDays($i)->setHour(rand(6, 20))->setMinute(0)->setSecond(0);

                TravelSchedule::create([
                    'destination' => $destination,
                    'departure_date' => $departureDateTime->format('Y-m-d'),
                    'departure_time' => $departureDateTime->format('H:i:s'),
                    'passenger_quota' => rand(8, 15),
                    'ticket_price' => rand(100000, 500000)
                ]);
            }
        }
    }
}

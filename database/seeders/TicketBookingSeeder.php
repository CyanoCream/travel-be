<?php

namespace Database\Seeders;

use App\Models\TicketBooking;
use App\Models\TravelSchedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketBookingSeeder extends Seeder
{
    public function run()
    {
        $passengers = User::where('role', 'PASSENGER')->get();
        $schedules = TravelSchedule::all();
        $statuses = ['PENDING', 'CONFIRMED', 'CANCELED'];

        // Create some random bookings
        foreach ($passengers as $passenger) {
            // Each passenger makes 2-4 bookings
            $numberOfBookings = rand(2, 4);

            for ($i = 0; $i < $numberOfBookings; $i++) {
                $schedule = $schedules->random();

                // Only create booking if quota is available
                if ($schedule->quota > $schedule->bookings()->count()) {
                    TicketBooking::create([
                        'user_id' => $passenger->id,
                        'travel_schedule_id' => $schedule->id,
                        'payment_status' => $statuses[array_rand($statuses)]
                    ]);
                }
            }
        }
    }
}

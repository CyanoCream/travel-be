<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\TicketBooking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $bookings = TicketBooking::where('payment_status', '!=', 'canceled')->get();
        $paymentStatuses = ['pending', 'paid', 'failed'];

        foreach ($bookings as $booking) {
            // Don't create payment for all bookings to simulate real scenarios
            if (rand(0, 1)) {
                Payment::create([
                    'ticket_booking_id' => $booking->id,
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_receipt' => rand(0, 1) ? 'receipts/payment_' . $booking->id . '.jpg' : null
                ]);
            }
        }
    }
}

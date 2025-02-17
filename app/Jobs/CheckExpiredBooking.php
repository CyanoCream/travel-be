<?php

namespace App\Jobs;

use App\Models\TicketBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiredBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    public function __construct(TicketBooking $booking)
    {
        $this->booking = $booking;
    }

    public function handle()
    {
        if ($this->booking->status === 'PENDING' && now()->gt($this->booking->expired_at)) {
            DB::transaction(function () {
                $this->booking->status = 'EXPIRED';
                $this->booking->save();
            });
        }
    }
}

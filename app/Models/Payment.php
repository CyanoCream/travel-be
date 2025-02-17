<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $guarded = ['id'];
    public function booking()
    {
        return $this->belongsTo(TicketBooking::class, 'booking_id');
    }
    public function ticketBooking()
    {
        return $this->belongsTo(TicketBooking::class);
    }
}

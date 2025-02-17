<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    protected $table = 'ticket_booking';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travelSchedule()
    {
        return $this->belongsTo(TravelSchedule::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'ticket_booking_id');
    }
}

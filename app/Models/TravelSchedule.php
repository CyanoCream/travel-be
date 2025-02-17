<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TravelSchedule extends Model
{
    use SoftDeletes;
    protected $table = 'travel_schedule';

    protected $guarded = ['id'];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime',
        'passenger_quota' => 'integer',
        'ticket_price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(TicketBooking::class, 'travel_schedule_id');
    }

}

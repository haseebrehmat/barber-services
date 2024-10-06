<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'persons',
        'date',
        'time',
        'info',
        'type',
        'status',
    ];

    public function scopeAppointments($query)
    {
        $query->where('type', '=', 2)->orderBy('date', 'DESC');
    }

    public function scopeReservations($query)
    {
        $query->where('type', '=', 1)->orderBy('date', 'DESC');
    }

}

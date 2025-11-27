<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'code',
        'departDate',
        'returnDate',
        'departCity',
        'destinations',
        'description',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

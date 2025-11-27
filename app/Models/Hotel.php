<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'ville',
        'distanceMasjid',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

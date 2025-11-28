<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
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

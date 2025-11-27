<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'pilgrim_id',
        'package_id',
        'room_id',
        'totalPrix',
        'montantPaye',
        'selectionne',
    ];

    public function pilgrim()
    {
        return $this->belongsTo(Pilgrim::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

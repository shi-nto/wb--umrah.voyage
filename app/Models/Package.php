<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'typePack',
        'category',
        'programme',
        'agent_id',
        'event_id',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'package_transports');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'package_hotels');
    }
}

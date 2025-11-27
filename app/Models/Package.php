<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'typePack',
        'typePelerin',
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
}

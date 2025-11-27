<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'nom',
        'telephone',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}

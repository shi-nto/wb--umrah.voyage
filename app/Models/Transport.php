<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'type',
        'provider',
        'departCity',
        'arriveCity',
        'departDate',
        'arriveDate',
        'status',
        'reference',
    ];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_transports');
    }
}

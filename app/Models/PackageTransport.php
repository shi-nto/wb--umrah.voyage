<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTransport extends Model
{
    protected $fillable = [
        'package_id',
        'transport_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
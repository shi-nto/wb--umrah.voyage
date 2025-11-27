<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageHotel extends Model
{
    protected $fillable = [
        'package_id',
        'hotel_id',
        'city',
        'nights',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

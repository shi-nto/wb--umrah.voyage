<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageTransport extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_id',
        'transport_id',
        'direction',
        'segment_order',
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

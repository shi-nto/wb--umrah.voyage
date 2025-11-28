<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transport extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'provider',
        'departCity',
        'arriveCity',
        'departDate',
        'arriveDate',
        'status',
        'reference',
        'price',
    ];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_transports');
    }
}

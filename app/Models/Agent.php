<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'telephone',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}

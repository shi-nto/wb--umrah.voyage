<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PassportInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'pilgrim_id',
        'numeroPasseport',
        'dateDelivrance',
        'dateExpiration',
    ];

    public function pilgrim()
    {
        return $this->belongsTo(Pilgrim::class);
    }
}

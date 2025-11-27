<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassportInfo extends Model
{
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

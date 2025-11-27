<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'pilgrim_id',
        'type',
        'message',
    ];

    public function pilgrim()
    {
        return $this->belongsTo(Pilgrim::class);
    }
}

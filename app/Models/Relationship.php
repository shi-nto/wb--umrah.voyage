<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $fillable = [
        'pilgrim_a_id',
        'pilgrim_b_id',
        'relationType',
    ];

    public function pilgrimA()
    {
        return $this->belongsTo(Pilgrim::class, 'pilgrim_a_id');
    }

    public function pilgrimB()
    {
        return $this->belongsTo(Pilgrim::class, 'pilgrim_b_id');
    }
}

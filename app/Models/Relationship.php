<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Relationship extends Model
{
    use HasFactory;
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

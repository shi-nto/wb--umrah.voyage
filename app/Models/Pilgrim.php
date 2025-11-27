<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pilgrim extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomFrancais',
        'nomArabe',
        'prenomArabe',
        'dateNaissance',
        'ville',
        'tel_1',
        'tel_2',
        'typeDiabete',
        'commentaire',
    ];

    public function passportInfo()
    {
        return $this->hasOne(PassportInfo::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function relationshipsFrom()
    {
        return $this->hasMany(Relationship::class, 'pilgrim_a_id');
    }

    public function relationshipsTo()
    {
        return $this->hasMany(Relationship::class, 'pilgrim_b_id');
    }
}

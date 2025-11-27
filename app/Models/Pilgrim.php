<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilgrim extends Model
{
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

    public function passportInfos()
    {
        return $this->hasMany(PassportInfo::class);
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
        return $this->hasMany(Relationship::class, 'from_pilgrim_id');
    }

    public function relationshipsTo()
    {
        return $this->hasMany(Relationship::class, 'to_pilgrim_id');
    }
}

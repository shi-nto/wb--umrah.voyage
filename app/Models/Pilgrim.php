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

    /**
     * Many passports for this pilgrim.
     */
    public function passports()
    {
        return $this->hasMany(PassportInfo::class);
    }

    /**
     * Keep compatibility for existing code that expects passportInfo to return one passport.
     * We'll return the latest passport by expiration date.
     */
    public function passportInfo()
    {
        // Use latestOfMany() if supported — fallback to ordering if not available.
        if (method_exists($this, 'hasOne')) {
            try {
                return $this->hasOne(PassportInfo::class)->latestOfMany('dateExpiration');
            } catch (\Throwable $e) {
                // Fallback: return the most recently-expired passport via collection
                return $this->passports()->orderByDesc('dateExpiration');
            }
        }

        return $this->passports()->orderByDesc('dateExpiration');
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

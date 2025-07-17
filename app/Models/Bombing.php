<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bombing extends Model
{
    use HasFactory;

    protected $fillable = [
        'attacker_country_id',
        'target_country_id',
        'weapon_id',
        'quantity',
    ];

    /**
     * The country that launched the bombing.
     */
    public function attackerCountry()
    {
        return $this->belongsTo(Country::class, 'attacker_country_id');
    }

    /**
     * The country that was targeted by the bombing.
     */
    public function targetCountry()
    {
        return $this->belongsTo(Country::class, 'target_country_id');
    }

    /**
     * The weapon used in the bombing.
     */
    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }


    public function views()
    {
        return $this->hasMany(BombingView::class);
    }
}

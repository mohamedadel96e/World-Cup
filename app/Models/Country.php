<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;
    protected $guarded = [];


    /**
     * Get the users associated with the country.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<User>
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }


    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'country_weapon')
            ->withTimestamps()
            ->withPivot(['quantity']);
    }


    public function supplyRequests()
    {
        return $this->hasMany(SupplyRequest::class);
    }

    protected static function booted()
    {
        static::deleting(function ($country) {
            $country->users()->each(function ($user) {
                $user->delete();
            });
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;
    protected $guarded = [];


    public function countries()
    {
        return $this->hasMany(Country::class, 'team_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function ($team) {
            $team->countries()->each(function ($country) {
                $country->delete();
            });
        });
    }
}

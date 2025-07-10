<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    /** @use HasFactory<\Database\Factories\WeaponFactory> */
    use HasFactory;
    protected $guarded = [];


    public function isAvailableForPurchase(): bool
    {
        return $this->is_available;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_weapon')
            ->withTimestamps()
            ->withPivot(['purchased_at', 'price_paid']);
    }

}

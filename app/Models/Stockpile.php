<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockpile extends Model
{
    /** @use HasFactory<\Database\Factories\StockpileFactory> */
    use HasFactory;

    protected $fillable = ['weapon_id', 'quantity'];

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }
}

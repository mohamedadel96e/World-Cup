<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $guarded = [];


    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->weapons()->each(function ($weapon) {
                $weapon->delete();
            });
        });
    }
}

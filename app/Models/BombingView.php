<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BombingView extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['bombing_id', 'user_id'];

    public function bombing()
    {
        return $this->belongsTo(Bombing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

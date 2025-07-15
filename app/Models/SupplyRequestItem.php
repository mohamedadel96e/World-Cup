<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyRequestItem extends Model
{
    protected $fillable = [
        'supply_request_id',
        'weapon_id',
        'quantity_requested',
        'quantity_provided',
        'status',
        'notes',
    ];


    public function supplyRequest()
    {
        return $this->belongsTo(SupplyRequest::class);
    }
    public function weapon()
    {
        return $this->hasOne(Weapon::class);
    }
}

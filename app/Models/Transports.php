<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transports extends Model
{
    protected $fillable = [
        'edited',
        'consumables',
        'name',
        'created',
        'cargo_capacity',
        'passengers',
        'max_atmosphering_speed',
        'crew',
        'length',
        'model',
        'cost_in_credits',
        'manufacturer',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function starships()
    {
        return $this->hasMany(Starship::class);
    }
}

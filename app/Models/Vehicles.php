<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = [
        'name', 'model', 'vehicle_class', 'manufacturer', 'cost_in_credits', 'length', 'crew', 'passengers',
        'max_atmosphering_speed', 'cargo_capacity', 'consumables',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'vehicle_films');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'vehicle_people');
    }}

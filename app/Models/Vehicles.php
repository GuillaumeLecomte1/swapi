<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = [
        'vehicle_class',
    ];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_vehicles');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'people_vehicles');
    }}

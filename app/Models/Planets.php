<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planets extends Model
{
    protected $fillable = [
        'name', 'diameter', 'rotation_period', 'orbital_period', 'gravity', 'population', 'climate', 'terrain', 'surface_water',
    ];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_planets', 'planet_id', 'film_id');
    }

    public function residents()
    {
        return $this->hasMany(People::class, 'homeworld');
    }

    public function getUrlAttribute()
    {
        return url("/planets/{$this->id}");
    }
}

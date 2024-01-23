<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = [
        'birth_year',
        'eye_color',
        'films',
        'gender',
        'hair_color',
        'height',
        'homeworld',
        'mass',
        'name',
        'skin_color',
    ];

    public function homeworld()
    {
        return $this->belongsTo(Planet::class, 'homeworld');
    }

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_people', 'people_id', 'film_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'people_species', 'people_id', 'species_id');
    }

    public function starships()
    {
        return $this->belongsToMany(Starship::class, 'people_starship', 'people_id', 'starship_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'people_vehicle', 'people_id', 'vehicle_id');
    }

    public function getUrlAttribute()
    {
        return url("/people/{$this->id}");
    }
}

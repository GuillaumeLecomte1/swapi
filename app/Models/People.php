<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = [
        'birth_year',
        'eye_color',
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
        return $this->belongsTo(Planets::class, 'homeworld', 'id');    
    }

    // Relation avec la table species (many-to-many)
    public function species()
    {
        return $this->belongsToMany(Species::class, 'people_species', 'people_id', 'species_id');
    }

    // Relation avec la table films (many-to-many)
    public function films()
    {
        return $this->belongsToMany(Films::class, 'people_films', 'people_id', 'film_id');
    }

    // Relation avec la table starships (many-to-many)
    public function starships()
    {
        return $this->belongsToMany(Starships::class, 'people_starships', 'people_id', 'starship_id');
    }

    // Relation avec la table vehicles (many-to-many)
    public function vehicles()
    {
        return $this->belongsToMany(Vehicles::class, 'people_vehicles', 'people_id', 'vehicle_id');
    }
    public function getUrlAttribute()
    {
        return url("/peoples/{$this->id}");
    }
}

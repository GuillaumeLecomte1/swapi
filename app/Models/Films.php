<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    protected $fillable = [
        'title',
        'episode_id',
        'opening_crawl',
        'director',
        'producer',
        'release_date',
    ];

    public function characters()
    {
        return $this->belongsToMany(People::class, 'film_character', 'film_id', 'people_id');
    }

    public function planets()
    {
        return $this->belongsToMany(Planet::class, 'film_planet', 'film_id', 'planet_id');
    }

    public function starships()
    {
        return $this->belongsToMany(Starship::class, 'film_starship', 'film_id', 'starship_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'film_vehicle', 'film_id', 'vehicle_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'film_species', 'film_id', 'species_id');
    }

    public function getUrlAttribute()
    {
        return url("/films/{$this->id}");
    }

}

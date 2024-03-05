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
        return $this->belongsToMany(People::class, 'people_films', 'film_id', 'people_id');
    }

    public function planets()
    {
        return $this->belongsToMany(Planets::class, 'film_planets', 'film_id', 'planet_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'film_species', 'film_id', 'species_id');
    }

    public function starships()
    {
        return $this->belongsToMany(Starships::class, 'film_starships', 'film_id', 'starship_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicles::class, 'film_vehicles', 'film_id', 'vehicle_id');
    }

    public function getUrlAttribute()
    {
        return url("/api/films/{$this->id}");
    }

}

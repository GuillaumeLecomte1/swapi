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
        return $this->belongsToMany(Film::class, 'people_films', 'people_id', 'film_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'people_species', 'people_id', 'species_id');
    }

    public function getUrlAttribute()
    {
        return url("/people/{$this->id}");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $fillable = [
        'name', 'classification', 'designation', 'average_height', 'average_lifespan', 'eye_colors', 'hair_colors', 'skin_colors', 'language', 'homeworld',
    ];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_species', 'species_id', 'film_id');
    }

    public function people()
    {
        return $this->belongsToMany(People::class, 'people_species','species_id', 'people_id');
    }

    public function homeworld()
    {
        return $this->belongsTo(Planets::class, 'homeworld');
    }
    public function getUrlAttribute()
    {
        return url("/species/{$this->id}");
    }

}


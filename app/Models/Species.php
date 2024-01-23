<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $fillable = [
        'name', 'classification', 'designation', 'average_height', 'average_lifespan', 'eye_colors', 'hair_colors', 'skin_colors', 'language',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'species_films');
    }

    public function people()
    {
        return $this->belongsToMany(People::class, 'species_people');
    }}

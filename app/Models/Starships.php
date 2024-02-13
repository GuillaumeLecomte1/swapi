<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starships extends Model
{
    protected $fillable = [
        'model', 'starship_class','hyperdrive_rating', 'MGLT',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_starships');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'people_starships');
    }}
